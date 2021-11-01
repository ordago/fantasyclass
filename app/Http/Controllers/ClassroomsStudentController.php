<?php

namespace App\Http\Controllers;

use App\Card;
use App\CardStudent;
use App\Challenge;
use App\ChallengesGroup;
use App\Classroom;
use App\Equipment;
use App\Http\Classes\Functions;
use App\Item;
use App\LogEntry;
use App\Student;
use App\Map;
use App\Notifications\NewInteractionStudent;
use App\Pet;
use App\Rating;
use App\Rules;
use App\Skill;
use App\Collection;
use App\Collectionable;
use Arcanedev\LaravelSettings\Utilities\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ClassroomsStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }


    public function updateavatar($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $data = request()->validate([
            'avatar' => ['image', 'nullable'],
            'url' => ['string', 'nullable'],
            'student_id' => ['numeric', 'nullable'],
        ]);

        if (request()->student_id) {
            $user = auth()->user();

            if (!$user->classrooms->where('id', $class->id)->where('pivot.role', '>', 0)->first()) {
                return false;
            }
            $student = Student::where('id', $data['student_id'])->firstOrFail();
            if ($student->classroom->classroom_id != $class->id) {
                return false;
            }
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        if (isset($data['url'])) {
            $student->update(['avatar_url' => $data['url']]);
            $avatar = $student->getMedia('avatar');
            if (count($avatar))
                $avatar[0]->delete();
        } else {
            settings()->setExtraColumns(['classroom_id' => $class->id]);
            $student->update(['avatar_url' => null]);
            $student->addMedia(request()->file('avatar'))
                ->toMediaCollection('avatar');

            $avatarPath = $student->getMedia('avatar')->first();
            $imgPath = $avatarPath->collection_name . "/" . $avatarPath->uuid . '/' . $avatarPath->file_name;
            $path = Storage::disk('public')->path('/') . $imgPath;
            Image::make($path)->resize(128, 128)->save();
        }
    }

    public function repair()
    {
        $data = request()->validate([
            'id' => ['required', 'numeric'],
            'gear' => ['required', 'numeric'],
        ]);
        $student = Student::findOrFail($data['id']);
        $class = Classroom::findOrFail($student->classroom->classroom_id);
        $this->authorize('studyOrTeach', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $gold = settings()->get('repair_equipment', 100);

        if ($student->gold < $gold)
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "times",
                "type" => "error",
            ];

        $student->setProperty('gold', $gold * -1, true, 'repair', true);
        $eq = $student->equipment()->where('equipment_id', $data['gear'])->first();
        $durability = min(100, $eq->pivot->durability + rand(20, 80));
        $student->equipment()->sync([$data['gear'] => ['durability' => $durability]], false);
        $student = $student->fresh();
        return [
            "message" => " " . __('success_error.update_success'),
            "icon" => "check",
            "type" => "success",
            "gold" => $student->gold,
            "equipment" => $student->equipment,
            "durability" => $durability,
        ];
    }

    public function feed()
    {
        $data = request()->validate([
            'id' => ['required', 'numeric']
        ]);

        $student = Student::findOrFail($data['id']);
        $class = Classroom::findOrFail($student->classroom->classroom_id);
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $feed = settings()->get('feed', 100);

        if ($student->gold < $feed)
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "times",
                "type" => "error",
            ];

        $student->setProperty('gold', $feed * -1, true, 'feed', true);
        $pet = $student->pets()->first();
        if ($pet) {
            $value = rand(20, 40);
            $hp = min($pet->pivot->hp + $value, 100);
            $student->pets()->sync([$pet->id => ['hp' => $hp]], false);
            $student = $student->fresh();
            $student->load('pets');
            return [
                "message" => " " . __('success_error.update_success'),
                "icon" => "check",
                "type" => "success",
                "student" => $student,
            ];
        }
    }

    public function checkVisibility($class)
    {
        settings()->setExtraColumns(['classroom_id' => $class]);
        settings()->get('state', 0);
        if (settings()->get('state', 0) == 2)
            abort(403);
    }

    public function getDocuments($class)
    {
        $student = Functions::getCurrentStudent($class);
        $docs = $class->documents()->with(["documents.students" => function ($q) use ($student) {
            $q->where('students.id', '=', $student->id);
        }, "documents" => function ($q) {
            $q->where('documents.visible', '=', 1)->orderBy('order');
        }])->get();
        return $docs;
    }

    public function getVideochats($class)
    {
        $student = Functions::getCurrentStudent($class);
        return $class->videochats()
            ->where('active', '=', 1)
            ->where(function ($query) use ($student) {
                $query->whereRaw('not JSON_CONTAINS(videochats.groups, ?)', [json_encode($student->groups->first()->id ?? '')])
                    ->orWhereNull('videochats.groups');
            })
            ->get();
    }

    public function getPaginatedStudents($class, $perPage, $offset)
    {
        $students = $class->students()->where('hidden', '=', 0)->offset($offset * $perPage)->take($perPage)->get()->map(function ($user) {
            $user->append('grouplogopublic');
            $user->load('equipment');
            $user->load('skills');
            $user->load('pets');
            $user->load('role');
            $user->load('character');
            return collect($user->toArray())
                ->only(['avatar', 'role', 'username', 'grouplogopublic', 'name', 'xp', 'hp', 'gold', 'character', 'equipment', 'pets', 'level', 'groups', 'skills'])
                ->all();
        });
        return $students;
    }

    public function getStudentPage($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        if (settings()->get('disable_student_view', 0) == 1)
            abort(403);

        $data = request()->validate([
            'page' => ['required', 'integer'],
        ]);
        $students = $this->getPaginatedStudents($class, env('MIX_MAX_STUDENTS'), $data['page']);
        return ['students' => $students];
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->with('characterTheme', 'students.equipment', 'students.character', 'students.pets', 'students.groups', 'theme', 'characterTheme.characters', 'students.skills')->firstOrFail();
        $this->checkVisibility($class->id);
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $student = Functions::getCurrentStudent($class);
        // $class->students->each->append('grouplogopublic');
        // $students = $class->students->where('hidden', '=', 0)->map(function ($user) {
        //     return collect($user->toArray())
        //         ->only(['avatar', 'username', 'grouplogopublic', 'name', 'xp', 'hp', 'gold', 'character', 'equipment', 'pets', 'level', 'groups', 'skills'])
        //         ->all();
        // });

        $rating = 0;
        $count = 0;
        foreach ($class->challengeGroups as $challengegr) {
            foreach ($challengegr->challenges as $challenge) {
                if ($challenge->rating) {
                    $rating += $challenge->rating;
                    $count++;
                }
            }
        }
        if ($count == 0) {
            $rating = 0;
        } else $rating = $rating / $count;

        $monsters = $class->monsters;

        $chat['title'] = sha1(env('CHAT_KEY') . $class->id);
        $chat['url'] = env('APP_URL_SHORT');
        $chat['chatbro_id'] = env('CHATBRO_ID');
        $chat['id'] = auth()->user()->id . '-' . $student->id;
        $chat['name'] = $student->name;
        if (strpos($student->avatar, "http") !== false)
            $chat['avatar'] = $student->avatar;
        else $chat['avatar'] = env('APP_URL') . $student->avatar;

        $chat['signature'] = md5(env('APP_URL_SHORT') . $chat['id'] . $chat['name'] . $chat['avatar'] . env('CHATBRO_KEY'));
        $showChat = settings()->get('show_chat', false);

        $settings['skill_enabled'] = settings()->get('skill_enabled', 0);

        $docs = $this->getDocuments($class);
        $videochats = $this->getVideochats($class);

        return view('studentsview.index', compact('class', 'docs', 'videochats', 'settings', 'student', 'chat', 'showChat', 'monsters', 'rating'));
    }


    public static function checkRequirements($challenge, $class, $student)
    {

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $tz = settings()->get('tz', 'Europe/Madrid');

        if (in_array($student->id, $challenge->students)) {
            return [false, "requirement", "Not allowed"];
        }

        if ($challenge->challenge_required) {
            $challenge_required = Challenge::find($challenge->challenge_required);
            if ($challenge_required->type == 0) {
                if (!$student->challenges->contains($challenge->challenge_required) || $student->challenges->where('id', $challenge->challenge_required)->first()->pivot->count == 0) {
                    return [false, "requirement", "ℹ️" . __('success_error.403reqChallenge') . $challenge_required->title];
                }
            } else {
                $group = $student->groups->first();
                if ($group && (!$group->challenges->contains($challenge->challenge_required) || $group->challenges->where('id', $challenge->challenge_required)->first()->pivot->count == 0 )) {
                    return [false, "requirement", "ℹ️" . __('success_error.403reqChallenge') . $challenge_required->title];
                }
            }
        }


        if ($challenge->datetime >= Carbon::now($tz)->toDateTimeString()) {
            return [false, "requirement", "ℹ️" . __('success_error.403time') . "⏱️" . $challenge->datetime];
        }

        if ($challenge->requirements && !$student->challenges->contains($challenge->id)) {
            $allItems = true;
            $content = '';
            foreach ($challenge->requirements as $item) {
                if (!$student->items->contains($item['id'])) {
                    $allItems = false;
                    $content .= "<img style='pointer-events: none;' class='coloredGray m-2' title='" . $item['alt'] . "' alt='" . $item['alt'] . "' src='" . $item['src'] . "' width='48px'>";
                } else {
                    $content .= "<img style='pointer-events: none;' class='m-2' title='" . $item['alt'] . "' alt='" . $item['alt'] . "' src='" . $item['src'] . "' width='48px'>";
                }
            }
            if (!$allItems) {
                $challenge->title = __('challenges.objects_required');
                $challenge->content = $content;
                $challenge->incomplete = true;
                return [false, "items", $challenge];
            }
        }

        return [true];
    }

    public function challenges($code)
    {
        $class = Classroom::where('code', '=', $code)->with('challengeGroups')->firstOrFail();
        $this->checkVisibility($class->id);
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);
        $challenges = [];

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $tz = settings()->get('tz', 'Europe/Madrid');

        foreach ($class->challengeGroups as $group) {
            array_push($challenges, $group->challenges()->with('attachments', 'comments', 'group')->where('datetime', '<=', Carbon::now($tz)->toDateTimeString())->get()->append('questioninfo')->map(function ($challenge) {
                return collect($challenge->toArray())
                    ->only(['id', 'rating', 'disabled', 'dateend', 'pinned', 'completion', 'type', 'title', 'xp', 'hp', 'gold', 'datetime', 'content', 'icon', 'color', 'is_conquer', 'cards', 'students', 'items', 'attachments', 'comments', 'group', 'questioninfo', 'challenge_required', 'requirements'])
                    ->all();
            }));
        }

        $all = [];
        foreach ($challenges as $section) {

            foreach ($section as $key => $value) {
                $current = Challenge::find($value['id']);
                if ($current->disabled || ($current->completion == 4 && !$student->challenges->contains($current->id))) {
                    unset($challenges[$key]);
                    continue;
                }
                $check = $this::checkRequirements($current, $class, $student);
                if (!$check[0]) {
                    if ($check[1] == "requirement") {
                        unset($section[$key]);
                        continue;
                    } else {
                        $value['title'] = $check[2]['title'];
                        $value['content'] = $check[2]['content'];
                        $value['incomplete'] = true;
                    }
                } else {
                    if ($current->is_conquer == 1) {
                        if ($current->type == 0) {
                            if ($student->challenges->contains($current->id) && $student->challenges()->where('challenge_id', $current->id)->first()->pivot->count == 1) {
                                $value['completed'] = true;
                            } else $value['completed'] = false;
                        } else {
                            if ($student->groups->first() && $student->groups->first()->challenges->contains($current->id)) {
                                $value['completed'] = true;
                            } else $value['completed'] = false;
                        }
                    }
                }

                if (Rating::where('student_id', $student->id)->where('challenge_id', $value['id'])->get()->count()) {
                    $value['rated'] = 1;
                } else $value['rated'] = 0;
                $students = $value['students'];
                if (!$students || array_search($student->id, $students) === false)
                    array_push($all, $value);
            }
        }
        $challenges = Arr::sort($all, function ($story) {
            return $story['datetime'];
        });
        $challenges = Arr::sort($challenges, function ($story) {
            if (isset($story['pinned']) && $story['pinned'] === 1) return 99999;
            return $story['datetime'];
        });

        $cats = $class->challengeGroups;

        $docs = $this->getDocuments($class);
        $videochats = $this->getVideochats($class);

        return view('studentsview.challenges', compact('class', 'docs', 'videochats', 'student', 'challenges', 'cats'));
    }

    public function getChallenge($code, $permalink)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = Functions::getCurrentStudent($class, []);
        $this->checkVisibility($class->id);
        $this->authorize('studyOrTeach', $class);
        $challenge = Challenge::where('id', '=', Functions::simple_crypt($permalink, "d"))->with('attachments', 'group', 'comments')->first()->append('questioninfo');

        $result = $this::checkRequirements($challenge, $class, $student);
        if (!$result[0] && $result[1] == "requirement") {
            abort(403, $result[2]);
        }
        if (!$result[0] && $result[1] == "items") {
            $challenge = $result[2];
        }
        if ($challenge->is_conquer == 1) {
            if ($challenge->type == 0) {
                if ($student->challenges->contains($challenge->id)) {
                    $challenge->completed = true;
                } else $challenge->completed = false;
            } else {
                if ($student->groups->first()->challenges->contains($challenge->id)) {
                    $challenge->completed = true;
                } else $challenge->completed = false;
            }
        }

        if (Rating::where('student_id', $student->id)->where('challenge_id', $challenge->id)->get()->count()) {
            $challenge->rated = 1;
        }
        $challenge->rated = 1;

        return view('studentsview.challenge', compact('challenge', 'class', 'student'));
    }

    public static function getChallenges($student, $class, $admin = false)
    {
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $tz = settings()->get('tz', 'Europe/Madrid');

        $challenges = DB::table('students')
            ->crossJoin('challenges')
            ->where('challenges.disabled', '=', 0)
            ->where('challenges.is_conquer', '=', 1)
            ->where('challenges.type', '=', 0)
            ->whereRaw('not JSON_CONTAINS(challenges.students, ?)', [json_encode($student->id)])
            ->where('challenges.datetime', '<=', Carbon::now($tz)->toDateTimeString())
            ->whereIn('challenges.id', function ($query) use ($class) {
                $query->select('challenges.id')
                    ->from('challenges')
                    ->join('challenges_groups', 'challenges_groups.id', 'challenges.challenges_group_id')
                    ->where('challenges_groups.classroom_id', '=', $class->id)
                    ->get();
            })
            ->where('students.id', '=', $student->id)
            ->leftJoin('challenge_student', function ($join) use ($student) {
                $join->on('challenges.id', '=', 'challenge_student.challenge_id')
                    ->where('challenge_student.student_id', '=', $student->id);
            })
            ->selectRaw('challenges.id, challenges.dateend, challenge_student.evaluated, challenges.pinned, challenges.type, challenges.collectionables, challenges.type_collectionable, challenges.objects, challenges.is_conquer, challenges.items, challenges.title, challenges.description, challenges.datetime, challenges.icon, challenges.color, challenges.xp, challenges.hp, challenges.gold, challenges.cards, challenges.completion, challenges.optional, challenge_student.count, challenges.challenge_required, challenges.challenges_group_id, challenges.requirements')
            ->get();


        $groups = $student->groups->pluck('id');

        $groupChallenges = DB::table('groups')
            ->crossJoin('challenges')
            ->where('challenges.disabled', '=', 0)
            ->where('challenges.is_conquer', '=', 1)
            ->where('challenges.type', '=', 1)
            ->where('challenges.datetime', '<=', Carbon::now($tz)->toDateTimeString())
            ->whereIn('challenges.challenges_group_id', function ($query) use ($class) {
                $query->select('challenges_groups.id')
                    ->from('challenges_groups')
                    ->where('challenges_groups.classroom_id', '=', $class->id)
                    ->get();
            })
            ->whereIn('groups.id', $groups)
            ->leftJoin('challenge_group', function ($join) use ($groups) {
                $join->on('challenges.id', '=', 'challenge_group.challenge_id')
                    ->whereIn('challenge_group.group_id', $groups);
            })
            ->selectRaw('challenge_group.group_id, challenges.dateend, challenges.pinned, challenges.id, challenges.type, challenges.collectionables, challenges.type_collectionable, challenges.objects, challenges.items, challenges.is_conquer, challenges.title, challenges.description, challenges.datetime, challenges.icon, challenges.color, challenges.xp, challenges.hp, challenges.gold, challenges.cards, challenges.completion, challenges.optional, challenge_group.count, challenges.challenge_required, challenges.challenges_group_id, challenges.requirements')
            ->get();

        $challenges = $challenges->merge($groupChallenges);
        foreach ($challenges as $key => $challenge) {
            $challenge->items = json_decode($challenge->items);
            if (!$admin) {
                $current = Challenge::find($challenge->id);
                if ($current->completion == 4 && !$student->challenges->contains($current->id)) {
                    unset($challenges[$key]);
                    continue;
                }
                $check = ClassroomsStudentController::checkRequirements($current, $class, $student);
                if (!$check[0]) {
                    if ($check[1] == "requirement") {
                        unset($challenges[$key]);
                        continue;
                    } else {
                        $challenge->title = $check[2]['title'];
                        $challenge->content = $check[2]['content'];
                        $challenge->incomplete = true;
                    }
                }
            }

            $challenge->permalink = Functions::simple_crypt($challenge->id);
            $group = ChallengesGroup::find($challenge->challenges_group_id);
            $challenge->group = [
                'name' => $group->name,
                'icon' => $group->icon,
            ];
        }
        return $challenges;
    }

    public function craft($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class);

        $data = request()->validate([
            'craft' => ['array', 'required'],
        ]);

        foreach ($data['craft'] as $craft) {
            if (!$student->items->contains($craft))
                abort(403);
        }
        foreach ($class->items as $item) {
            if ($item->craft) {
                $count = count($item->craft);
                if (count($data['craft']) == $count) {
                    foreach ($item->craft as $craft) {
                        if (array_search($craft['id'], $data['craft']) !== false) {
                            $count--;
                        }
                    }
                    if ($count === 0) {
                        if ($item->min_lvl) {
                            if (!$student->level || $student->level && $student->level->number < $item->min_lvl) {
                                return [
                                    "message" => " " . __('success_error.shop_failed_level'),
                                    "icon" => "times",
                                    "type" => "error",
                                ];
                            }
                        }
                        // Remove the combined objects
                        foreach ($data['craft'] as $itemRemove) {
                            $studentItem = $student->items->where('id', $itemRemove)->first();
                            if ($studentItem)
                                $count = $studentItem->pivot->count - 1;
                            else $count = 0;
                            if ($count == 0) {
                                $student->items()->detach($itemRemove);
                            } else {
                                $student->items()->sync([$itemRemove => ['count' => $count]], false);
                            }
                        }
                        // Add new item or update count
                        $studentItem = $student->items->where('id', $item->id)->first();
                        if ($studentItem)
                            $count = $studentItem->pivot->count + 1;
                        else $count = 1;
                        $student->items()->sync([$item->id => ['count' => $count]], false);

                        return [
                            "message" => " " . __('success_error.update_success'),
                            "icon" => "check",
                            "type" => "success",
                            "item" => $item,
                            "items" => $student->fresh()->items,
                        ];
                    }
                }
            }
        }
        return [
            "message" => " " . __('success_error.craft_fail'),
            "icon" => "times",
            "type" => "error",
        ];
    }

    public function show($code, $section = false)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'collections.collectionables', 'characterTheme.characters')->firstOrFail();
        $this->checkVisibility($class->id);
        $this->authorize('studyOrTeach', $class);
        $admin = false;
        $student = Functions::getCurrentStudent($class);

        $student->notifyLevel = false;

        // Is there a new level?
        if ($student->level) {
            if (Cache::has('lvl-' . $student->id)) {
                $lvl = Cache::get('lvl-' . $student->id);
                if ($lvl != $student->level->number) {
                    if ($lvl < $student->level->number) {
                        $student->notifyLevel = true;
                    }
                    $expiresAt = Carbon::now()->addDays(365);
                    Cache::put('lvl-' . $student->id, $student->level->number, $expiresAt);
                }
            } else {
                $expiresAt = Carbon::now()->addDays(365);
                Cache::put('lvl-' . $student->id, $student->level->number, $expiresAt);
            }
        }

        $student->append('numcards');
        $student->load('character');
        $student->load('collections');
        $student->load('collectionables');


        // Shop information
        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $items = $eq0 = $eq1 = $eq2 = $eq3 = $craft = null;
        if (settings()->get('items_visibility', false) ? true : false) {
            $items = Item::where('classroom_id', '=', $class->id)->where('for_sale', '=', '1')->get();
        }
        if($student->character) {
            if ($student->character->theme->id == 10 || $student->character->theme->id == 11)
                $eq0 = Equipment::where('offset', '=', 0)->whereNotIn('id', [640, 641, 642, 643, 644, 645, 646, 647, 648, 649, 710, 711, 712, 713, 714, 715, 716, 717, 718, 760, 770, 780])->whereRaw('JSON_CONTAINS(character_id, ?)', [json_encode($student->character_id)])->get();
            if (settings()->get('equipment_1_visibility', false) ? true : false) {
                $eq1 = Equipment::where('offset', '=', 1)->whereRaw('JSON_CONTAINS(character_id, ?)', [json_encode($student->character_id)])->get();
            }
            if (settings()->get('equipment_2_visibility', false) ? true : false) {
                $eq2 = Equipment::where('offset', '=', 2)->whereRaw('JSON_CONTAINS(character_id, ?)', [json_encode($student->character_id)])->get();
            }
            if (settings()->get('equipment_3_visibility', false) ? true : false) {
                $eq3 = Equipment::where('offset', '=', 3)->whereRaw('JSON_CONTAINS(character_id, ?)', [json_encode($student->character_id)])->get();
            }
        }

        if (settings()->get('show_recipes', false) ? true : false) {
            $craft = $class->items()->whereNotNull('craft')->where('craft', 'NOT LIKE', '\[\]')->get();
        }

        $pets = Pet::where('classroom_id', $class->id)->where('for_sale', 1)->get();

        $shop = [
            'items' => json_encode($items),
            'eq0' => json_encode($eq0),
            'eq1' => json_encode($eq1),
            'eq2' => json_encode($eq2),
            'eq3' => json_encode($eq3),
            'craft' => json_encode($craft),
            'multiplier1' => (float) settings()->get('shop_multiplier_1', 1),
            'multiplier2' => (float) settings()->get('shop_multiplier_2', 1),
            'multiplier3' => (float) settings()->get('shop_multiplier_3', 1),
        ];

        $challenges = $this::getChallenges($student, $class);

        $cards = $student->cards;
        $student->append('boost');
        $student->load('badges');
        foreach ($student->getAutomaticBadges() as $badge) {
            $student->badges->push($badge);
        }

        $student->load('pets');
        $student->load('blogs');
        $student->load('role');
        $student->load('skills');

        $student->append('blogsp');
        $student->groups->each->append('blogs');

        $evaluationsPending = DB::table('evaluables')
            ->where('evaluables.classroom_id', '=', $class->id)
            ->where('evaluables.type', '=', 1)
            ->selectRaw('evaluables.id, evaluables.description, evaluables.rubric_id, evaluables.subtype')
            ->get();

        $pending = [];
        foreach ($evaluationsPending as $eval) {
            if ($eval->subtype == 1 || $eval->subtype == 3) {
                if ($student->groups->first())
                    foreach ($student->groups->first()->students as $stdgroup) {
                        if ($student->id == $stdgroup['id'])
                            continue;
                        $evaluationStdPending = DB::table('evaluable_student')
                            ->where('evaluable_student.evaluable_id', '=', $eval->id)
                            ->where('evaluable_student.from_student_id', '=', $student->id)
                            ->where('evaluable_student.student_id', '=', $stdgroup['id'])
                            ->get();
                        if (!count($evaluationStdPending))
                            array_push($pending, ['id' => $eval->id, 'rubric_id' => $eval->rubric_id, 'name' => $eval->description, 'student_id' => $stdgroup->id, 'student_name' => $stdgroup->name, 'subtype' => $eval->subtype]);
                    }
            } 
            
            if ($eval->subtype == 2 || $eval->subtype == 3) {
                $evaluationStdPending = DB::table('evaluable_student')
                    ->where('evaluable_student.evaluable_id', '=', $eval->id)
                    ->where('evaluable_student.from_student_id', '=', $student->id)
                    ->where('evaluable_student.student_id', '=', $student->id)
                    ->get();
                if (!count($evaluationStdPending))
                    array_push($pending, ['id' => $eval->id, 'rubric_id' => $eval->rubric_id, 'name' => $eval->description, 'student_id' => $student->id, 'student_name' => $student->name, 'subtype' => $eval->subtype]);
            }
        }
        $evaluation = null;
        $evaluation[1] = $pending;
        if (settings()->get('eval_visible', false)) {
            $grades = collect();
            $grades->push(["namegroup" => __('evaluation.first'), "icon" => 'fas fa-chart-line', "evaluation" => EvaluationController::individualReport($class, [$student], null)]);
            foreach ($class->evalgroups as $evalg) {
                $grades->push(["namegroup" => $evalg->name, "icon" => $evalg->icon, "evaluation" => EvaluationController::individualReport($class, [$student], $evalg)]);
            }
            $evaluation[0] = $grades;
        }

        $settings = EvaluationController::getEvalSettings($class->id);
        $settings['allow_upload'] = settings()->get('allow_upload', 0);
        $settings['allow_buy_cards'] = settings()->get('allow_buy_cards', 0);
        $settings['card_price'] = settings()->get('card_price', 600);
        $settings['allow_change_class'] = settings()->get('allow_change_class', 1);
        $settings['allow_send_money'] = settings()->get('allow_send_money', 0);
        $settings['transfer_fee'] = settings()->get('transfer_fee', 10);
        $settings['disable_your_adventure'] = settings()->get('disable_your_adventure', 0);
        $settings['feed'] = settings()->get('feed', 100);
        $settings['repair_equipment'] = settings()->get('repair_equipment', 100);
        $settings['impostor'] = settings()->get('impostor', -1);
        $settings['announcement'] = settings()->get('announcement', "");
        $settings['comission_collectibles'] = settings()->get('comission_collectibles', 0);
        if ($settings['impostor'] != -1) {
            if ($settings['impostor'] == $student->id)
                $settings['impostor'] = true;
            else $settings['impostor'] = false;
        }
        $settings['skill_enabled'] = settings()->get('skill_enabled', 0);
        if ($settings['skill_enabled'] != 0)
            $settings['skill_price'] = settings()->get('skill_price', 600);

        $students_money = json_encode([]);
        if ($settings['allow_send_money']) {
            $students_money = $class->students()->pluck('classroom_user_id', 'name');
        }

        $settings['buy_collectionable'] = settings()->get('buy_collectionable', 0);
        if ($settings['buy_collectionable']) {
            $settings['buy_collectionable_count'] = settings()->get('buy_collectionable_count', 3);
            $settings['buy_collectionable_gold_pack'] = settings()->get('buy_collectionable_gold_pack', 200);
        }

        $chat['title'] = sha1(env('CHAT_KEY') . $class->id);
        $chat['url'] = env('APP_URL_SHORT');
        $chat['chatbro_id'] = env('CHATBRO_ID');
        $chat['id'] = auth()->user()->id . '-' . $student->id;
        $chat['name'] = $student->name;
        if (strpos($student->avatar, "http") !== false)
            $chat['avatar'] = $student->avatar;
        else $chat['avatar'] = env('APP_URL') . $student->avatar;

        $chat['signature'] = md5(env('APP_URL_SHORT') . $chat['id'] . $chat['name'] . $chat['avatar'] . env('CHATBRO_KEY'));
        $showChat = settings()->get('show_chat', false);

        $notifications = auth()->user()->unreadNotifications()->where('data->classroom', $code)->where('data->user', 'student')->get();

        $docs = $this->getDocuments($class);
        $videochats = $this->getVideochats($class);

        if ($section)
            $tab = $section;

        $student->unsetRelation('grades');
        $student->grades = $student->grades()->whereNull('from_student_id')->get();
        $student->load(['logEntries' => function($query) {
            $query->orderByDesc('id')->take(100);
        }]);
        return view('studentsview.show', compact('student', 'section', 'docs', 'videochats', 'students_money', 'class', 'admin', 'shop', 'challenges', 'cards', 'evaluation', 'settings', 'chat', 'showChat', 'pets', 'notifications'));
    }

    public function rules($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $rules = Rules::where('classroom_id', $class->id)->first();
        $rules = Functions::replaceSpecial($rules->content, $class);
        $student = Functions::getCurrentStudent($class, []);

        return view('studentsview.rules', compact('class', 'rules', 'student'));
    }

    public function addRating()
    {
        $data = request()->validate([
            'rating' => ['numeric', 'required'],
            'challenge' => ['numeric', 'required'],
        ]);

        $challenge = Challenge::findOrFail($data['challenge']);

        $class = Classroom::where('id', $challenge->classroom())->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);
        $student->ratings()->sync([$challenge->id => ['rating' => $data['rating']]], false);
        return $challenge->fresh()->rating;
    }
    public function licenses($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);

        return view('studentsview.licenses', compact('class', 'student'));
    }

    public function sendMoney($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('study', $class);
        $student = Functions::getCurrentStudent($class, []);
        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $to = Student::where('classroom_user_id', '=', request()->to)->firstOrFail();
        if ($to->classroom->classroom_id != $class->id || request()->money > $student->gold || !settings()->get('allow_send_money', 0) || $to->id == $student->id) {
            abort(403);
        }
        $fee = settings()->get('transfer_fee', 10);

        $gold = request()->money - request()->money * $fee / 100;
        $steal = 0;

        if (Functions::getProbability(60)) {
            $steal = ($gold * rand(0, 20) / 100);
            $gold = $gold - $steal;
        }

        $student->setProperty('gold', request()->money * -1, true, 'send', true);
        $to->setProperty('gold', $gold, true, 'received', true);

        $from['title'] = 'notifications.money_sent';
        $from['name'] = $student->name;
        $from['datetime'] = Carbon::now();

        $message = __('notifications.money_sent') . ' ' . request()->money . ' <i class="fas fa-coins colored"></i> ' . __('notifications.money_sent_taxes') . ($gold + $steal) . " <i class='fas fa-coins colored'></i> ";

        if ($steal) {
            $message .= __('notifications.money_sent_thief') . $steal . " <i class='fas fa-coins colored'></i> " . __('notifications.money_sent_total') . $gold . " <i class='fas fa-coins colored'></i>";
        }

        Notification::send($to->classroom->user, new NewInteractionStudent('notifications.money_sent', $message, $from, "money_sent", $class->code));
        return ['gold' => request()->money, 'received' => $gold, 'steal' => $steal];
    }

    public function passwordChallenge($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);

        $data = request()->validate([
            'challenge' => ['numeric', 'required'],
            'password' => ['string', 'required'],
        ]);

        $update = false;

        $challenge = Challenge::findOrFail($data['challenge']);
        $challengeStudent = $student->challenges->where('id', $challenge->id)->first();
        $update = false;
        if ($challenge->completion == 3 && $data['password'] == $challenge->password) {
            if (!$challengeStudent) {
                $student->challenges()->attach($challenge->id);
                $update = true;
            }
        } else {
            $student = $student->fresh();
            return [
                'success' => false,
                'hp' => $student->hp,
                'xp' => $student->xp,
                'gold' => $student->gold,
                'items' => $student->items,
                'challenges' => $this::getChallenges($student, $class),
            ];
        }

        if ($update) {
            $cards = [];
            if ($challenge->auto_assign == 1) {
                for ($i = 0; $i < $challenge->cards; $i++) {
                    array_push($cards, CardsController::getRandomCard($class->code));
                }
            }
            $student->assignChallenge($challenge, 1, $cards);
        }

        $from['title'] = $challenge->title;
        $from['name'] = $student->name;
        $from['username'] = $student->username;
        $from['datetime'] = Carbon::now();

        NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.challenge_password", __("notifications.challenge_password") . $from['title'], $from, "challenge", "challenges");

        $student = $student->fresh();

        return [
            'success' => true,
            'hp' => $student->hp,
            'xp' => $student->xp,
            'gold' => $student->gold,
            'items' => $student->items,
            'challenges' => $this::getChallenges($student, $class),
        ];
    }
    public function removeExchange($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $data = request()->validate([
            'id' => ['numeric', 'required'],
        ]);
        $line = DB::table('exchange_collectibles')
            ->where('id', $data['id'])
            ->first();
        $student = Functions::getCurrentStudent($class, []);
        if($student->id != $line->student_id)
            abort(403);
        
        DB::table('exchange_collectibles')->where('id', $data['id'])->delete();

    }

    public function doExchange($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $data = request()->validate([
            'id' => ['numeric', 'required'],
        ]);
        $line = DB::table('exchange_collectibles')
            ->where('id', $data['id'])
            ->first();
        $studentOrigin = Student::find($line->student_id);
        $student = Functions::getCurrentStudent($class, []);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $comission = settings()->get('comission_collectibles', 0);
        if($comission)
            if($student->gold < $comission || $studentOrigin->gold < $comission)
                return false;

        if($student->classroom->classroom_id != $studentOrigin->classroom->classroom_id)
            return false;
        
        $studentOriginCollectionable = $studentOrigin->fresh()->collectionables->where('id', $line->collectionable_id)->first();
        if($studentOriginCollectionable->pivot->count <= 1)
            return false;

        $studentCollectionable = $student->fresh()->collectionables->where('id', $line->wanted_collectionable_id)->first();
        if($studentCollectionable->pivot->count <= 1)
            return false;
        
        $countOrigin =  $studentOriginCollectionable->pivot->count -1;   
        $count =  $studentCollectionable->pivot->count -1;

        $newOrigin = $studentOrigin->fresh()->collectionables->where('id', $line->wanted_collectionable_id)->first();
        if($newOrigin)
            $newCountOrigin = $newOrigin->pivot->count + 1;
        else
            $newCountOrigin = 1;
        $new = $student->fresh()->collectionables->where('id', $line->collectionable_id)->first();
        if($new)
            $newCount = $new->pivot->count + 1;
        else
            $newCount = 1;

        $studentOrigin->collectionables()->sync([$line->collectionable_id => ['count' => $countOrigin]], false);
        $studentOrigin->collectionables()->sync([$line->wanted_collectionable_id => ['count' => $newCountOrigin]], false);
        
        $student->collectionables()->sync([$line->wanted_collectionable_id => ['count' => $count]], false);
        $student->collectionables()->sync([$line->collectionable_id => ['count' => $newCount]], false);

        if($comission) {
            $student->setProperty("gold", $comission * -1, true, "exchange_collectible", false);
            $studentOrigin->setProperty("gold", $comission * -1, true, "exchange_collectible", false);
        }

        DB::table('exchange_collectibles')->where('id', $data['id'])->delete();

        return ['collectionables' => $student->fresh()->collectionables, 'gold' => $student->gold];
    }

    public function getExchange($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $exchanges = DB::table('exchange_collectibles')
            ->where('classroom_id', $class->id)
            ->get();

        $lines = [];
        foreach ($exchanges as $exchange) {
            $from = Collectionable::find($exchange->collectionable_id);
            $to = Collectionable::find($exchange->wanted_collectionable_id);
            $student = Student::find($exchange->student_id);
            $lines[] = ['id' => $exchange->id,'from' => $from, 'to' => $to, 'student' => ['id' => $student->id, 'name' => $student->name, 'avatar' => $student->avatar]];
        }

        return $lines;
    }

    public function exchangeCollectible($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);
        $data = request()->validate([
            'from' => ['numeric', 'required'],
            'to' => ['numeric', 'required'],
        ]);

        $studentCollectionable = $student->collectionables->where('id', $data['from'])->first();

        if(!$studentCollectionable || $studentCollectionable->pivot->count <= 1)
            abort(403);
        
        DB::table('exchange_collectibles')->insert([
            'classroom_id' => $class->id,
            'student_id' => $student->id,
            'collectionable_id' => $data['from'],
            'wanted_collectionable_id' => $data['to'],
        ]);        

    }
    public function markChallenge($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);

        $data = request()->validate([
            'challenge' => ['numeric'],
        ]);
        $update = false;

        $challenge = Challenge::findOrFail($data['challenge']);
        $challengeStudent = $student->challenges->where('id', $challenge->id)->first();
        $update = false;
        $feedback = null;
        if ($challenge->completion == 1 || $challenge->completion == 3) {
            $feedback = $challenge->feedback;
        }
        if ($challenge->completion == 1) {
            if (!$challengeStudent) {
                $student->challenges()->attach($challenge->id);
                $update = true;
            } else if($challengeStudent->pivot->count == 0) {
                $student->challenges()->sync([$challenge->id => ['count' => 1]], false);
                $update = true;
            }
        } else if ($challenge->completion == 2) {
            if ($student->challenges->where('id', $challenge->id)->first()->count == 2) {
                $update = true;
            }
        }
        if ($update) {
            $cards = [];
            if ($challenge->auto_assign == 1) {
                for ($i = 0; $i < $challenge->cards; $i++) {
                    array_push($cards, CardsController::getRandomCard($class->code));
                }
            }
            $student->assignChallenge($challenge, 1, $cards);
        }

        $from['title'] = $challenge->title;
        $from['name'] = $student->name;
        $from['username'] = $student->username;
        $from['datetime'] = Carbon::now();

        NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.mark_challenge", __("notifications.mark_challenge") . $from['title'], $from, "challenge", "challenges");

        return [
            'success' => true,
            'hp' => $student->hp,
            'xp' => $student->xp,
            'gold' => $student->gold,
            'challenges' => $this::getChallenges($student->fresh(), $class),
            'feedback' => $feedback,
            'items' => $student->fresh()->items,
        ];
    }

    public function markCard($code, $id)
    {

        $data = request()->validate([
            'type' => ['numeric'],
            'student' => ['numeric', 'nullable'],
        ]);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        if ($data['student']) {
            $student = Student::where('id', $data['student'])->firstOrFail();
            if ($student->classroom->classroom_id != $class->id)
                return false;
        } else
            $student = Functions::getCurrentStudent($class, []);

        $card = Card::where('id', '=', $id)->where('classroom_id', '=', $class->id)->first();
        if ($card->gold) {
            if ($card->gold < 0) {
                if ($student->gold + $card->gold < 0) {
                    return [
                        "message" => " " . __('success_error.shop_failed_money'),
                        "icon" => "times",
                        "type" => "error",
                    ];
                }
            }
        }

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        if ($data['type'] == 1)
            $cost = settings()->get('card_use', 200);
        else
            $cost = settings()->get('card_delete', 50);

        if (!$card->special && $card->gold == 0 && $student->gold < $cost) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "times",
                "type" => "error",
            ];
        }


        $cardLine = CardStudent::where('card_id', $card->id)
            ->where('student_id', $student->id)
            ->orderBy('marked')
            ->first();

        $cardLine->update(['marked' => $data['type']]);

        $from['title'] = __("notifications.mark_card");
        $from['name'] = $student->name;
        $from['username'] = $student->username;
        $from['datetime'] = Carbon::now();


        if ($card->automatic) {
            $data['action'] = true;
            return CardsController::useDeleteCard($student, $card, $cardLine, $class, $data);
            NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.used_card", __("notifications.used_card_content") . ": " . $card->title, $from, "mark_card", '');
        } else {
            NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.mark_card", __("notifications.mark_card_content"), $from, "mark_card", '');
        }

        return [
            "message" => " " . __('success_error.update_success'),
            "icon" => "check",
            "type" => "success",
        ];
    }
    public function buyPet($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $data = request()->validate([
            'pet' => ['numeric', 'required'],
        ]);

        $student = Functions::getCurrentStudent($class, []);

        if ($student->hp == 0)
            return false;

        $pet = Pet::where('id', $data['pet'])->where('classroom_id', $class->id)->where('for_sale', 1)->firstOrFail();

        if ($pet->price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        $student->pets()->sync([]);
        $student->pets()->sync([$pet->id]);
        $student->update(['gold' => ($student->gold - $pet->price)]);

        LogEntry::create([
            'type' => 'gold',
            'value' => $pet->price * -1,
            'student_id' => $student->id,
            'message' => 'pet',
        ]);

        return [
            "message" => " " . __('shop.adopt_success'),
            "icon" => "check",
            "type" => "success",
            "pets" => $student->fresh()->pets,
            "boost" => $student->fresh()->getBoost(),
        ];
    }

    public function claimReward($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $student = Functions::getCurrentStudent($class, []);

        $data = request()->validate([
            "collection" => ['numeric', 'required'],
        ]);

        $collection = Collection::findOrFail($data['collection']);
        if ($collection->classroom_id != $class->id)
            abort(403);

        foreach ($collection->collectionables as $collectionable) {
            $studentCollectionable = $student->fresh()->collectionables->where('id', $collectionable->id)->first();

            if ($studentCollectionable)
                $count = $studentCollectionable->pivot->count - 1;
            else abort(403);
            if ($count == 0)
                $student->collectionables()->detach($collectionable->id);
            else
                $student->collectionables()->sync([$collectionable->id => ['count' => $count]], false);
        }

        $studentCollection = $student->fresh()->collections->where('id', $collection->id)->first();

        if ($studentCollection)
            $count = $studentCollection->pivot->count + 1;
        else $count = 1;

        $student->collections()->sync([$collection->id => ['count' => $count]], false);

        $student->setProperty("xp", $collection->xp, true, 'collection', true);
        $student->setProperty("gold", $collection->gold, true, 'collection', true);
        $student = $student->fresh();
        return [
            "student" => $student,
            "collections" => $student->collections,
            "collectionables" => $student->collectionables,
        ];
    }

    public function buyPackCollectionables($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $student = Functions::getCurrentStudent($class, []);
        if ($student->hp == 0)
            abort(403);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $settings['buy_collectionable'] = settings()->get('buy_collectionable', 0);
        if ($settings['buy_collectionable'] == 0)
            abort(403);
        $settings['buy_collectionable_count'] = settings()->get('buy_collectionable_count', 3);
        $settings['buy_collectionable_gold_pack'] = settings()->get('buy_collectionable_gold_pack', 200);



        if ($settings['buy_collectionable_gold_pack'] > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        $data = request()->validate([
            'collection' => ['numeric', 'required'],
        ]);

        $collectionables = collect();
        for ($i = 0; $i < $settings['buy_collectionable_count']; $i++) {
            $collectionable = CollectionableController::getRandomCollectionable($data['collection'], $class->id);
            $studentCollectionable = $student->fresh()->collectionables->where('id', $collectionable->id)->first();

            if ($studentCollectionable)
                $count = $studentCollectionable->pivot->count + 1;
            else $count = 1;
            $collectionables->push($collectionable);
            $student->collectionables()->sync([$collectionable->id => ['count' => $count]], false);
        }
        $student->update(['gold' => ($student->gold - $settings['buy_collectionable_gold_pack'])]);
        LogEntry::create([
            'type' => 'gold',
            'value' => $settings['buy_collectionable_gold_pack'] * -1,
            'student_id' => $student->id,
            'message' => 'collection',
        ]);
        return [
            "type" => "success",
            "get_collectionables" => $collectionables,
            "collectionables" => $student->fresh()->collectionables,
            'gold' => $student->fresh()->gold,
        ];
    }

    public function useSkill($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        if (isset(request()->student)) {
            $student = Student::findOrFail(request()->student);
            if ($student->classroom->classroom_id != $class->id)
                abort(403);
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        $skill = Skill::findOrFail(request()->skill);

        if (!$student->skills->contains($skill->id))
            abort(403);

        switch ($skill->properties['type']) {
            case 'undo_action':
                SkillsController::undoAction($student);
                break;
            case 'steal_xp':
                $xp = rand($skill->properties['xp_min'], $skill->properties['xp_max']);
                $students = $class->students()->where('students.id', '!=', $student->id)->inRandomOrder()->limit($skill->properties['users'])->get();
                $xpStd = 0;
                foreach ($students as $std) {
                    if (!$std->checkSkill('protection_steal')) {
                        $xpStd += min($xp, $std->xp);
                        $std->setProperty("xp", $xp * -1, true, 'skill', true);
                        $std->classroom->user->sendMessage($student->name . " " . __('skills.stolen_you') . " <i class='fas fa-fist-raised colored'></i>", $class->code, 'skill', false);
                    } else {
                        $student->classroom->user->sendMessage($std->name . " " . __('skills.stopped_stolen'), $class->code, 'skill', false);
                        $std->classroom->user->sendMessage(__('skills.have_stopped') . " " . $student->name, $class->code, 'skill', false);
                    }
                }
                $student->setProperty("xp", $xpStd, true, 'skill', true);
                break;
            case 'steal_money':
                $gold = rand($skill->properties['money_min'], $skill->properties['money_max']);
                $students = $class->students()->where('students.id', '!=', $student->id)->inRandomOrder()->limit($skill->properties['users'])->get();
                $goldStd = 0;
                foreach ($students as $std) {
                    if (!$std->checkSkill('protection_steal')) {
                        $goldStd += min($gold, $std->gold);
                        $std->setProperty("gold", $gold * -1, true, 'skill', true);
                        $std->classroom->user->sendMessage($student->name . " " . __('skills.stolen_you') . " <i class='fas fa-coins colored'></i>", $class->code, 'skill', false);
                    } else {
                        $student->classroom->user->sendMessage($std->name . " " . __('skills.stopped_stolen'), $class->code, 'skill', false);
                        $std->classroom->user->sendMessage(__('skills.have_stopped') . " " . $student->name, $class->code, 'skill', false);
                    }
                }
                $student->setProperty("gold", $goldStd, true, 'skill', true);
                break;
            case 'heal_classroom':
                $hp = rand($skill->properties['hp_min'], $skill->properties['hp_max']);
                foreach ($class->students as $std) {
                    if ($std->hp == 0)
                        continue;
                    $mult = 1;
                    if ($student->id == $std->id)
                        $mult = -1;
                    $std->setProperty('hp', $hp * $mult, true, 'skill', true);
                }
                break;
            case 'heal_group':
                $hp = rand($skill->properties['hp_min'], $skill->properties['hp_max']);
                $group = $student->groups->first();
                if ($group) {
                    foreach ($group->students as $std) {
                        if ($std->hp == 0)
                            continue;
                        $mult = 1;
                        if ($student->id == $std->id)
                            $mult = -1;
                        $std->setProperty('hp', $hp * $mult, true, 'skill', true);
                    }
                } else abort(403);
                break;
            case 'heal_self':
                $hp = rand($skill->properties['hp_min'], $skill->properties['hp_max']);
                $student->setProperty('hp', $hp, true, 'skill');
                break;
        }

        $from['title'] = __("notifications.use_skill");
        $from['name'] = $student->name;
        $from['username'] = $student->username;
        $from['datetime'] = Carbon::now();

        NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.use_skill", __("notifications.use_skill_content") . ": " . __($skill->name), $from, "use_skill", '');
        $this->deleteSkill($code, request()->skill);
        $student = $student->fresh();
        $student->load('skills');
        $student->load(['log_entries' => function($query) {
            $query->orderByDesc('id')->take(50);
        }]);
        return $student;
    }

    public function deleteSkill($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        if (isset(request()->student)) {
            $student = Student::findOrFail(request()->student);
            if ($student->classroom->classroom_id != $class->id)
                abort(403);
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }
        $lastSkill = $student->skills()->where('skill_id', request()->skill)->first();
        if ($lastSkill->pivot->count == 1) {
            $student->skills()->detach($lastSkill);
        } else {
            $student->skills()->sync([$lastSkill->id => ['count' => $lastSkill->pivot->count - 1]], false);
        }
        return $student->fresh()->skills;
    }

    public static function getRandomSkill($class)
    {
        return Skill::where('classroom_id', $class->id)
            ->inRandomOrder()
            ->first();
    }

    public function buyCard($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $student = Functions::getCurrentStudent($class, []);
        $student->append('numcards');

        if ($student->hp == 0 || settings()->get('allow_buy_cards', 0) == 0)
            return false;

        if ($student->numcards[0] >= $student->numcards[1]) {
            return [
                "message" => " " . __('success_error.max_cards_reached'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        $price = settings()->get('card_price', 600);
        if ($price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        $card = CardsController::getRandomCard($code);
        $student->cards()->attach($card->id);
        $student->update(['gold' => ($student->gold - $price)]);

        return [
            "message" => " " . __('success_error.skill_success'),
            "icon" => "check",
            "type" => "success",
            "card" => $card,
            "cards" => $student->fresh()->cards,
            "numcards" => $student->fresh()->numcards,
        ];
    }
    public function buySkill($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        if (isset(request()->id)) {
            $student = Student::findOrFail(request()->id);
            if ($student->classroom->classroom_id != $class->id)
                abort(403);
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        if ($student->hp == 0 || settings()->get('skill_enabled', 0) == 0 || $student->skills->count() >= 4)
            return false;

        $price = settings()->get('skill_price', 600);
        if ($price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        $have = [];
        foreach ($student->skills->pluck('properties')->toArray() as $line) {
            array_push($have, $line['type']);
        }

        if ($class->skills->count() == 0) {
            return [
                "message" => " " . __('skills.no_available'),
                "icon" => "times",
                "type" => "error",
            ];
        }

        $flag = true;
        $protection = 0;
        while (true && $protection < 100) {
            $skill = $this::getRandomSkill($class);
            if ($skill->type == 0) {
                $flag = true;
                break;
            }
            foreach ($student->skills as $skillStd) {
                if ($skill->properties['type'] == $skillStd->properties['type']) {
                    $flag = false;
                    $protection++;
                    continue;
                }
            }
            if (!$flag) {
                $flag = true;
                continue;
            }
            $protection++;
            $flag = true;
            break;
        }
        if ($flag && $protection != 100) {
            $studentSkill = $student->skills->where('id', $skill->id)->first();
            if ($studentSkill)
                $count = $studentSkill->pivot->count + 1;
            else $count = 1;
            // TODO, has count the same time.
            $student->skills()->sync([$skill->id => ['count' => $count]], false);
            // $student->skills()->attach([$skill->id => ['count' => $count]]);
            $student->update(['gold' => ($student->gold - $price)]);
            LogEntry::create([
                'type' => 'gold',
                'value' => $price * -1,
                'student_id' => $student->id,
                'message' => 'skill',
            ]);

            return [
                "message" => " " . __('success_error.skill_success'),
                "icon" => "check",
                "type" => "success",
                "skills" => $student->fresh()->skills,
            ];
        }
        return [
            "message" => " " . __('skills.no_available'),
            "icon" => "times",
            "type" => "error",
        ];
    }
    public function buyItem($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        if (!settings()->get('items_visibility', false))
            abort(403);

        $student = Functions::getCurrentStudent($class, []);

        if ($student->hp == 0)
            return false;

        $data = request()->validate([
            'item' => 'numeric',
        ]);

        $item = Item::where('id', '=', $data['item'])->where('classroom_id', '=', $class->id)->where('for_sale', '=', '1')->firstOrFail();
        $studentItem = $student->items->where('id', $item->id)->first();

        if ($item->price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        if ($student->level && $item->min_lvl > $student->level->number) {
            return [
                "message" => " " . __('success_error.shop_failed_level'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        if ($studentItem)
            $count = $studentItem->pivot->count + 1;
        else $count = 1;


        $student->items()->sync([$item->id => ['count' => $count]], false);
        $student->update(['gold' => ($student->gold - $item->price)]);
        LogEntry::create([
            'type' => 'gold',
            'value' => $item->price * -1,
            'student_id' => $student->id,
            'message' => 'shop',
        ]);

        $from['title'] = __("notifications.item");
        
        
            $from['datetime'] = Carbon::now();
            $from['name'] = $student->name;
            $from['username'] = $student->username;
    
            NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.item", $item->icon , $from, "item", $student->id);

        return [
            "message" => " " . __('success_error.equipment_success'),
            "icon" => "check",
            "type" => "success",
            "items" => $student->fresh()->items,
        ];
    }

    public function buyEquipment($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $student = Functions::getCurrentStudent($class, []);

        if ($student->hp == 0)
            abort(403);

        $new = Equipment::where('id', '=', request()->new)->firstOrFail();

        // $old = Equipment::where('id', '=', request()->old)->firstOrFail();
        $old = DB::table('equipment_student')
            ->join('equipment', 'equipment.id', 'equipment_student.equipment_id')
            ->where('equipment_student.student_id', '=', $student->id)
            ->where('equipment.type', '=', $new->type)
            ->select('*')
            ->first();

        // Avoid user mistakes
        if ($old->type != $new->type || ($new->offset > 0 && $old->offset >= $new->offset) || array_search($student->character_id, json_decode($new->character_id)) === false || $student->equipment->contains($new->id)) {
            return [
                "message" => " " . __('success_error.shop_failed_exists'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        switch ($new->offset) {
            case 1:
            default:
                if (!settings()->get('equipment_1_visibility', false))
                    abort(403);
                $key = "shop_multiplier_1";
                break;
            case 2:
                if (!settings()->get('equipment_2_visibility', false))
                    abort(403);
                $key = "shop_multiplier_2";
                break;
            case 3:
                if (!settings()->get('equipment_3_visibility', false))
                    abort(403);
                $key = "shop_multiplier_3";
                break;
            case 0:
                $key = "shop_multiplier_1";
                break;
        }
        $mult = (float) settings()->get($key, 1);
        $price = round($new->price * $mult);
        if ($price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        $gold = $student->gold - $price;
        $student->update(['gold' => $gold]);
        if ($gold)
            LogEntry::create([
                'type' => 'gold',
                'value' => $price * -1,
                'student_id' => $student->id,
                'message' => 'shop',
            ]);
        $student->equipment()->detach($old->id);
        $student->equipment()->attach($new->id);
        return [
            "message" => " " . __('success_error.equipment_success'),
            "icon" => "check",
            "type" => "success",
            "equipment" => $student->fresh()->equipment,
            "boost" => $student->fresh()->getBoost(),
        ];
    }

    public function useItem($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $data = request()->validate([
            'id' => 'numeric',
            'itemId' => 'numeric',
        ]);

        $student = Functions::getCurrentStudent($class, []);

        $item = $student->items->where('id', '=', $data['itemId'])->first();
        if ($student->hp <= 0 && $item->undead == 0)
            return false;


        if (!$item->pivot->count > 0)
            return false;

        if ($item->pivot->count == 1) {
            $student->items()->detach($item->id);
        } else
            $student->items()->updateExistingPivot($item->id, ['count' => $item->pivot->count - 1]);

        $extra = 0;
        if ($item->hp > 0) {
            if ($student->checkSkill('heal_passive')) {
                $extra = $student->getIncrement('heal_passive', $item->hp);
                $student->setProperty('hp', $extra, true, 'skill');
                $student->classroom->user->sendMessage(__('skills.heal_passive_effective'), $class->code, 'skill', false);
            }

            $student->setProperty('hp', $item->hp, true, 'item');
        }
        $xp = $student->xp;
        if ($item->xp > 0) {
            $xp = $student->setProperty('xp', $item->xp, true, 'item');
            $xp = $xp['xp'];
        }

        $from['title'] = __("notifications.use_item");
        
        
        $from['datetime'] = Carbon::now();
        $from['name'] = $student->name;
        $from['username'] = $student->username;
        NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.use_item", $item->icon , $from, "item", $student->id);


        return ['xp' => $xp, 'hp' => $item->hp + $extra];
    }

    public function map($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $activeMap = settings()->get('active_map');

        $map = Map::where('id', '=', $activeMap)->firstOrFail();

        $student = Functions::getCurrentStudent($class);
        return view('studentsview.map', compact('class', 'map', 'student'));
    }
}
