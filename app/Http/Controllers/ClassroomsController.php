<?php

namespace App\Http\Controllers;

use App\Behaviour;
use App\Card;
use App\ChallengesGroup;
use App\Classroom;
use App\ClassroomUser;
use App\Event;
use App\GoalThemes;
use App\Grouping;
use App\Theme;
use App\Item;
use App\QuestionBank;
use App\Rules;
use App\Student;
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
            'bgtheme' => ['required', 'integer'],
            'charTheme' => ['required', 'integer'],
        ]);

        $class->update([
            'name' => $data['name'],
            'adventure_name' => $data['adventureName'],
            'character_theme' => $data['charTheme'],
            'theme_id' => $data['bgtheme'],
            'goal_type' => $data['goalType'],
        ]);

        return redirect('/classroom/' . $code);
    }

    public function clone($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);

        $new = $class->replicate();
        $new->code = $this->reference(8);
        $new->enrollment_code = $this->reference(5);
        $new->name = $new->name." (copy)";

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
        
        // Clone challenge groups and challenges
        foreach ($class->challengeGroups as $challengeGroup) {
            $newChGr = $challengeGroup->replicate();
            $newChGr->classroom_id = $new->id;
            $newChGr->push();
            foreach ($challengeGroup->challenges as $challenge) {
                $newChallenge = $challenge->replicate();
                $newChallenge->challenges_group_id = $newChGr->id;
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
            'bgtheme' => ['required', 'integer'],
            'charTheme' => ['required', 'integer'],
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
            'theme_id' => $data['bgtheme'],
            'goal_type' => $data['goalType'],
        ]);

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
        } catch (\Throwable $th) {
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
        session()->forget('bypass_student');
        return view('classrooms.index', compact('user'));
    }

    public function destroy($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);
        $class->delete();
        return "/classroom";
    }

    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'behaviours', 'grouping.groups')->firstOrFail();
        $this->authorize('view', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $students = $class->students()->with('equipment', 'pets')->get();
        $groups = $class->grouping->first()->groups;

        $students->each->append('numcards');
        $students->each->append('boost');

        $pending = collect();
        foreach ($class->students as $student) {
            $cards = $student->cards->where('pivot.marked', ">", 0);
            if ($cards->count())
                $pending->add(['student' => $student, 'cards' => $cards]);
        }

        $chat['title'] = sha1(env('CHAT_KEY').$class->id); 
        $chat['url'] = env('APP_URL_SHORT'); 
        $chat['chatbro_id'] = env('CHATBRO_ID');
        $chat['id'] = '999999-'.auth()->user()->id;
        $chat['name'] = 'Teacher';
        $chat['avatar'] = env('APP_URL').'/img/icons/teacher.svg';

        $chat['signature'] = md5(env('APP_URL_SHORT').$chat['id'].$chat['name'].$chat['avatar'].'delete'.env('CHATBRO_KEY')); 

        $showChat = settings()->get('show_chat', false);

        return view('classrooms.show', compact('class', 'students', 'pending', 'groups', 'chat', 'showChat'));
    }
}
