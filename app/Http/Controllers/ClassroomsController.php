<?php

namespace App\Http\Controllers;

use App\Behaviour;
use App\Card;
use App\ChallengesGroup;
use App\Classroom;
use App\ClassroomUser;
use App\EvaluablesGroup;
use App\GoalThemes;
use App\Grouping;
use App\Theme;
use App\Item;
use App\Rules;
use App\Student;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ClassroomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function reference($num)
    {

        $unique = strtolower(Str::random($num));
        $check = Classroom::where('code', $unique)->first();
        if ($check) {
            return $this->reference($num);
        }
        return $unique;
    }

    public function regenerate($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $code = $this->reference(5);
        $class->update([
            'enrollment_code' => $code,
        ]);

        return $code;
    }

    public function update($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'adventureName' => ['required', 'string', 'min:3', 'max:255'],
            'goalType' => ['required', 'integer'],
            'bgtheme' => ['nullable'],
            'background' => ['nullable'],
            'charTheme' => ['required', 'integer'],
        ]);

        $class->update([
            'name' => $data['name'],
            'adventure_name' => $data['adventureName'],
            'character_theme' => $data['charTheme'],
            'theme_id' => isset($data['bgtheme']) ? $data['bgtheme'] : null,
            'goal_type' => $data['goalType'],
        ]);
        
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        if(isset($data['bgtheme'])) {
            settings()->forget('background');
        } else {
            settings()->set('background', $data['background']);
        }

        return redirect('/classroom/' . $code);
    }

    public function reward($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        foreach ($class->students as $student) {
            if ($student->hp > 0) {
                if (request()->xp)
                    $student->setProperty('xp', request()->xp, true, 'battle');
                if (request()->gold)
                    $student->setProperty('gold', request()->gold, true, 'battle');
            }
        }
    }

    public function removeMedia($code, $id)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);
        $media = Media::where('id',  $id)->where('model_type', 'App\Classroom')->where('model_id', $class->id)->firstOrFail();
        $collection = $media->collection_name;
        $media->forceDelete();
        return $class->getMedia($collection);
    }
    public function add2collection($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);

        if (request()->file('image')) {

            $media = $class->addMedia(request()->file('image'))
                ->toMediaCollection(request()->collection);
            return $class->getMedia(request()->collection);
        }
    }
    public function clone($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);

        $new = $class->replicate();
        $new->code = $this->reference(8);
        $new->enrollment_code = $this->reference(5);
        $new->name = $new->name . " (copy)";

        $new->push();

        // Clone cards
        foreach ($class->cards as $card) {
            $newCard = $card->replicate();
            $newCard->classroom_id = $new->id;
            $newCard->push();
        }

        // Clone items
        foreach ($class->items as $item) {
            $newItem = $item->replicate();
            $newItem->classroom_id = $new->id;
            $newItem->push();
        }

        // Clone badges
        foreach ($class->badges as $badge) {
            $newBadge = $badge->replicate();
            $newBadge->classroom_id = $new->id;
            $newBadge->push();
        }

        // Clone levels
        foreach ($class->levels as $level) {
            $newLevel = $level->replicate(['media']);
            $newLevel->classroom_id = $new->id;
            $newLevel->push();

            $level->media->each(function (Media $media) use ($newLevel) {
                $props = $media->toArray();
                unset($props['uuid']);
                unset($props['id']);
                $newLevel->addMedia($media->getPath())
                    ->preservingOriginal()
                    ->withProperties($props)
                    ->toMediaCollection($media->collection_name);
            });
        }

        // Clone rules
        $newRules = $class->rules->replicate();
        $newRules->classroom_id = $new->id;
        $newRules->push();

        // Clone maps
        foreach ($class->maps as $map) {
            $newMap = $map->replicate();
            $newMap->classroom_id = $new->id;
            $newMap->push();
        }
        
        // Clone question banks
        foreach ($class->questionBanks as $qb) {
            $newQb = $qb->replicate();
            $newQb->classroom_id = $new->id;
            $newQb->push();
            foreach ($qb->questions as $question) {
                $newQuestion = $question->replicate();
                $newQuestion->question_bank_id = $newQb->id;
                $newQuestion->push();
            }
        }

        // Clone documents
        foreach ($class->documents as $documentcat) {
            $newDocument = $documentcat->replicate();
            $newDocument->classroom_id = $new->id;
            $newDocument->push();
            foreach ($documentcat->documents as $document) {
                $newDoc = $document->replicate();
                $newDoc->document_category_id = $newDocument->id;
                $newDoc->push();
            }
        }

        // Clone challenge groups and challenges
        foreach ($class->challengeGroups as $challengeGroup) {
            $newChGr = $challengeGroup->replicate();
            $newChGr->classroom_id = $new->id;
            $newChGr->push();
            foreach ($challengeGroup->challenges as $challenge) {
                $newChallenge = $challenge->replicate();
                $newChallenge->challenges_group_id = $newChGr->id;
                $newChallenge->requirements = [];
                $newChallenge->items = [];
                $newChallenge->push();

                foreach ($challenge->questions as $question) {
                    $newQuestion = $question->replicate();
                    $newQuestion->challenge_id = $newChallenge->id;
                    $newQuestion->push();
                }

                foreach ($challenge->attachments as $attachment) {
                    $newAttachment = $attachment->replicate();
                    $newAttachment->challenge_id = $newChallenge->id;
                    $newAttachment->push();
                }
            }
        }

        // Clone groupings
        foreach ($class->grouping as $grouping) {
            $newGrouping = $grouping->replicate();
            $newGrouping->classroom_id = $new->id;
            $newGrouping->push();
        }

        // Clone behaviours
        foreach ($class->behaviours as $behaviour) {
            $newBehaviour = $behaviour->replicate();
            $newBehaviour->classroom_id = $new->id;
            $newBehaviour->push();
        }

        // Clone events
        foreach ($class->events as $event) {
            $newEvent = $event->replicate();
            $newEvent->classroom_id = $new->id;
            $newEvent->push();
        }

        // Clone tags
        if($class->tags)
        foreach ($class->tags as $tag) {
            $newTag = $tag->replicate();
            $newTag->classroom_id = $new->id;
            $newTag->push();
        }

        // Clone pets
        foreach ($class->pets as $pet) {
            $newPet = $pet->replicate();
            $newPet->classroom_id = $new->id;
            $newPet->push();
        }
        
        // Clone Monsters
        foreach ($class->monsters as $monster) {
            $newMonster = $monster->replicate();
            $newMonster->classroom_id = $new->id;
            $newMonster->push();
        }

        // Clone skills
        foreach ($class->skills as $skill) {
            $newSkill = $skill->replicate();
            $newSkill->classroom_id = $new->id;
            $newSkill->push();
        }

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $allSettings = settings()->all();

        settings()->setExtraColumns(['classroom_id' => $new->id]);
        foreach ($allSettings as $key => $value) {
            settings()->set($key, $value);
        }

        auth()->user()->classrooms()->attach([
            $new->id => ['role' => 2],
        ]);
    }

    public function store()
    {
        $data = request()->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'adventureName' => ['required', 'string', 'min:3', 'max:255'],
            'goalType' => ['required', 'integer'],
            'bgtheme' => ['nullable'],
            'background' => ['nullable'],
            'charTheme' => ['required', 'integer'],
            'filled' => ['nullable'],
        ]);

        if ($validator->fails()) {
            return redirect('/classroom/create')
                ->withErrors($validator)
                ->withInput();
        }

        $classroom = Classroom::create([
            'name' => $data['name'],
            'adventure_name' => $data['adventureName'],
            'code' => $this->reference(8),
            'enrollment_code' => $this->reference(5),
            'character_theme' => $data['charTheme'],
            'theme_id' => isset($data['bgtheme']) ? $data['bgtheme'] : null,
            'goal_type' => $data['goalType'],
        ]);

        settings()->setExtraColumns(['classroom_id' => $classroom->id]);
        if(!isset($data['bgtheme'])) {
            settings()->set('background', $data['background']);
        }

        if (isset($data['filled']) && $data['filled']) {
            // Assign basic items
            foreach (Item::whereNull('classroom_id')->get() as $item) {
                $newItem = $item->replicate();
                $classroom->items()->save($newItem);
            }

            // Assign cards
            foreach (Card::whereNull('classroom_id')->where('shared', '=', 0)->get() as $card) {
                $newCard = $card->replicate();
                $classroom->cards()->save($newCard);
            }

            // Assign behaviours
            foreach (Behaviour::whereNull('classroom_id')->get() as $behaviour) {
                $newBehaviour = $behaviour->replicate();
                $classroom->cards()->save($newBehaviour);
            }
        }

        // Create default challenges group
        ChallengesGroup::create([
            'name' => 'General',
            'icon' => 'fas fa-home',
            'classroom_id' => $classroom->id,
        ]);

        // Create default grouping
        Grouping::create([
            'name' => 'General',
            'classroom_id' => $classroom->id,
        ]);

        Rules::create([
            'classroom_id' => $classroom->id,
            'content' => file_get_contents(public_path() . '/rules/' . auth()->user()->locale . '.txt')
        ]);

        // Create default evaluables group
        EvaluablesGroup::create([
            'name' => 'General',
            'icon' => 'fas fa-chart-line',
            'classroom_id' => $classroom->id,
        ]);

        auth()->user()->classrooms()->attach([
            $classroom->id => ['role' => 2],
        ]);

        return redirect('/classroom');
    }

    public function join($code)
    {
        $class = Classroom::where('enrollment_code', '=', $code)->firstOrFail();
        $user = auth()->user();
        $id = $user->id;
        $classId = $class->id;
        try {
            ClassroomUser::create([
                'user_id' => $id,
                'classroom_id' => $classId,
                'role' => 0,
            ]);
        }
        catch (\Throwable $th) {
            return false;
        }

        // Get the new insertion id (another way? :/)
        $cuid = ClassroomUser::select('id')
            ->where('user_id', '=', $id)
            ->where('classroom_id', '=', $classId)
            ->where('role', '=', 0)
            ->get()
            ->first();

        // Create the student properties
        $student = Student::create([
            'classroom_user_id' => $cuid->id,
            'name' => auth()->user()->name,
            'character_id' => Classroom::findOrFail($classId)->characterTheme->characters->random(1)->first()->id,
        ]);

        // Assign basic equipment
        $student->setBasicEquipment();

        return redirect('/classroom');
    }

    public function edit($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'behaviours')->firstOrFail();
        $this->authorize('view', $class);
        $goals = GoalThemes::All();
        $themes = Theme::All();
        return view('classrooms.create', compact('goals', 'themes', 'class'));
    }

    public function create()
    {
        $goals = GoalThemes::All();
        $themes = Theme::All();
        return view('classrooms.create', compact('goals', 'themes'));
    }

    public function index()
    {
        $user = auth()->user();

        $notifications = auth()->user()->unreadNotifications()->get();

        session()->forget('bypass_student');
        return view('classrooms.index', compact('user', 'notifications'));
    }

    public function destroy($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);
        $class->delete();
        return "/classroom";
    }

    public function getPaginatedStudents($class, $perPage, $offset, $order, $search = "") {
        if($order == "name")
            $orderType = "orderBy";
        else $orderType = "orderByDesc";
        if($search) {
            return $class->students()->whereRaw("LOWER(name) LIKE ?", '%'.strtolower($search).'%')->$orderType($order)->offset($offset * $perPage)->take($perPage)->get();
        } else return $class->students()->$orderType($order)->offset($offset * $perPage)->take($perPage)->get();
    
    }

    public function getStudentPage($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $data = request()->validate([
            'page' => ['required', 'integer'],
            'order' => ['required', 'string'],
            'search' => ['nullable', 'string'],
        ]);
        $students = $this->getPaginatedStudents($class, env('MIX_MAX_STUDENTS'), $data['page'], $data['order'], isset($data['search']) ? $data['search'] : '');
        $students->each->load('equipment');
        $students->each->load('pets');
        $students->each->load('character');

        $students->each->append('numcards');
        $students->each->append('boost');
        $students->each->load('skills');
        return ['students' => $students];
    }

    public function pendingCards($code) {
        $class = Classroom::where('code', '=', $code)->with('theme', 'characterTheme', 'behaviours', 'grouping.groups')->firstOrFail();
        $this->authorize('view', $class);
        $pending = collect();

        $allStudents = DB::table('students')
        ->join('classroom_user', function ($join) use ($class) {
            $join->on('students.classroom_user_id', '=', 'classroom_user.id')
                ->where('classroom_user.classroom_id', '=', $class->id);
        })
        ->pluck('students.id');


        $pendingCards = DB::table('card_student')
        ->join('cards', function ($join) {
            $join->on('card_student.card_id', '=', 'cards.id')
            ->where('card_student.marked', '>', 0);
        })
        ->join('students', function ($join) use($allStudents) {
            $join->on('students.id', '=', 'card_student.student_id')
            ->whereIn('students.id', $allStudents);
        })
        ->selectRaw('cards.*, card_student.*, students.name, students.id')
        ->get();
        return $pendingCards;
    }

    public function searchStudents($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);

    }
    
    public function getAllStudents($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $allStudents = DB::table('students')
        ->join('classroom_user', function ($join) use ($class) {
            $join->on('students.classroom_user_id', '=', 'classroom_user.id')
                ->where('classroom_user.classroom_id', '=', $class->id);
        })
        ->selectRaw('students.name, students.id, students.avatar_url')
        ->get();
        return $allStudents;
    }

    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'characterTheme', 'behaviours', 'grouping.groups')->firstOrFail();
        $this->authorize('view', $class);

        $notifications = auth()->user()->unreadNotifications()->where('data->classroom', $code)->where('data->user', 'teacher')->get();

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $groups = $class->grouping->first()->groups;

        $chat['title'] = sha1(env('CHAT_KEY') . $class->id);
        $chat['url'] = env('APP_URL_SHORT');
        $chat['chatbro_id'] = env('CHATBRO_ID');
        $chat['id'] = '999999-' . auth()->user()->id;
        $chat['name'] = 'Teacher';
        $chat['avatar'] = env('APP_URL') . '/img/icons/teacher.svg';
        
        $chat['signature'] = md5(env('APP_URL_SHORT') . $chat['id'] . $chat['name'] . $chat['avatar'] . 'delete' . env('CHATBRO_KEY'));
        
        $showChat = settings()->get('show_chat', false);
        
        $settings['skill_enabled'] = settings()->get('skill_enabled', 0);

        $impostor = settings()->get('impostor', -1);
        if($impostor != -1) {
            $impostor = Student::find($impostor);
        }

        $pending = $this->pendingCards($code);

        return view('classrooms.show', compact('class', 'pending', 'settings', 'impostor', 'notifications', 'groups', 'chat', 'showChat'));
    }
}
