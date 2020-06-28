<?php

namespace App\Http\Controllers;

use App\Card;
use App\CardStudent;
use App\Challenge;
use App\Classroom;
use App\Equipment;
use App\Http\Classes\Functions;
use App\Item;
use App\Student;
use App\User;
use App\Map;
use App\Rules;
use Arcanedev\LaravelSettings\Utilities\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

        $data = request()->validate([
            'avatar' => ['image'],
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

        $student->addMedia(request()->file('avatar'))
            ->toMediaCollection('avatar');

        $avatarPath = $student->getMedia('avatar')->first();
        $imgPath = $avatarPath->collection_name . "/" . $avatarPath->id . '/' . $avatarPath->file_name;
        $path = Storage::disk('public')->path('/') . $imgPath;
        Image::make($path)->resize(128, 128)->save();
    }

    public function checkVisibility($class) {
        settings()->setExtraColumns(['user_id' => $class]);
        settings()->get('state', 0);
        if(settings()->get('state', 0) == 2)
            abort(403);
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->with('students.equipment', 'students.groups', 'theme')->firstOrFail();
        $this->checkVisibility($class->id);        
        $student = Functions::getCurrentStudent($class);
        $students = $class->students->map(function ($user) {
            return collect($user->toArray())
                ->only(['avatar', 'name', 'xp', 'hp', 'gold', 'equipment', 'level', 'groups'])
                ->all();
        });


        return view('studentsview.index', compact('class', 'student', 'students'));
    }

    public function stories($code)
    {
        $class = Classroom::where('code', '=', $code)->with('challengeGroups')->firstOrFail();
        $this->checkVisibility($class->id);
        $student = Functions::getCurrentStudent($class, []);
        $stories = collect();

        foreach ($class->challengeGroups as $group) {
            $stories = $group->challenges()->with('attachments', 'comments')->where('datetime', '<=', Carbon::now()->toDateTimeString())->get()->append('questioninfo')->map(function ($challenge) {
                return collect($challenge->toArray())
                    ->only(['id', 'title', 'xp', 'hp', 'gold', 'datetime', 'content', 'icon', 'color', 'is_conquer', 'cards', 'attachments', 'comments', 'questioninfo'])
                    ->all();
            });
        }
        $stories = Arr::sort($stories, function ($story) {
            // Sort the student's scores by their name.
            return $story['datetime'];
        });
        return view('studentsview.stories', compact('class', 'student', 'stories'));
    }

    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'characterTheme.characters')->firstOrFail();
        $this->checkVisibility($class->id);
        $admin = false;
        $student = Functions::getCurrentStudent($class);

        // Shop information
        settings()->setExtraColumns(['user_id' => $class->id]);

        $items = $eq1 = $eq2 = $eq3 = null;
        if (settings()->get('items_visibility', false) ? true : false) {
            $items = Item::where('classroom_id', '=', $class->id)->where('for_sale', '=', '1')->get();
        }
        if (settings()->get('equipment_1_visibility', false) ? true : false) {
            $eq1 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 1)->get();
        }
        if (settings()->get('equipment_2_visibility', false) ? true : false) {
            $eq2 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 2)->get();
        }
        if (settings()->get('equipment_3_visibility', false) ? true : false) {
            $eq3 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 3)->get();
        }

        $shop = [
            'items' => json_encode($items),
            'eq1' => json_encode($eq1),
            'eq2' => json_encode($eq2),
            'eq3' => json_encode($eq3),
        ];

        $challenges = DB::table('students')
            ->crossJoin('challenges')
            ->where('challenges.is_conquer', '=', 1)
            ->where('challenges.type', '=', 0)
            ->where('challenges.datetime', '<=', Carbon::now()->toDateTimeString())
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
            ->selectRaw('challenges.id, challenges.type, challenges.is_conquer, challenges.title, challenges.description, challenges.datetime, challenges.icon, challenges.color, challenges.xp, challenges.hp, challenges.gold, challenges.cards, challenges.completion, challenges.optional, challenge_student.count')
            ->get();

        $groups = $student->groups->pluck('id');

        $groupChallenges = DB::table('groups')
            ->crossJoin('challenges')
            ->where('challenges.is_conquer', '=', 1)
            ->where('challenges.type', '=', 1)
            ->where('challenges.datetime', '<=', Carbon::now()->toDateTimeString())
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
            ->selectRaw('challenge_group.group_id, challenges.id, challenges.type, challenges.is_conquer, challenges.title, challenges.description, challenges.datetime, challenges.icon, challenges.color, challenges.xp, challenges.hp, challenges.gold, challenges.cards, challenges.completion, challenges.optional, challenge_group.count')
            ->get()->all();

        $challenges = $challenges->merge($groupChallenges);
        $cards = $student->cards;
        $student->append('boost');

        return view('studentsview.show', compact('student', 'class', 'admin', 'shop', 'challenges', 'cards'));
    }

    public function rules($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $rules = Rules::where('classroom_id', $class->id)->first();
        $rules = Functions::replaceSpecial($rules->content, $class);
        $student = Functions::getCurrentStudent($class, []);

        return view('studentsview.rules', compact('class', 'rules', 'student'));
    }

    public function markChallenge($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = Functions::getCurrentStudent($class, []);

        $data = request()->validate([
            'challenge' => ['numeric'],
        ]);
        $update = false;

        $challenge = Challenge::findOrFail($data['challenge']);
        $challengeStudent = $student->challenges->where('id', $challenge->id)->first();
        $update = false;
        if ($challenge->completion == 1) {
            if (!$challengeStudent) {
                $student->challenges()->attach($challenge->id);
                $update = true;
            }
        } else if ($challenge->completion == 2) {
            if ($student->challenges->where('id', $challenge->id)->first()->count == 2) {
                $update = true;
            }
        }
        if ($update) {
            $student->setProperty('hp', $challenge->hp, true);
            $student->setProperty('xp', $challenge->xp, true);
            $student->setProperty('gold', $challenge->gold, true);
        }
        return [
            'success' => true,
            'hp' => $student->hp,
            'xp' => $student->xp,
            'gold' => $student->gold,
        ];
    }

    public function markCard($code, $id)
    {

        $data = request()->validate([
            'type' => ['numeric'],
            'student' => ['numeric', 'nullable'],
        ]);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        
        if($data['student']) {
            $student = Student::where('id', $data['student'])->firstOrFail();
            if($student->classroom->classroom_id != $class->id)
                return false;
        } else 
            $student = Functions::getCurrentStudent($class, []);
        
        $card = Card::where('id', '=', $id)->where('classroom_id', '=', $class->id)->first();
        $cardLine = CardStudent::where('card_id', $card->id)
        ->where('student_id', $student->id)
        ->orderBy('marked')
        ->first();
        
        $cardLine->update(['marked' => $data['type']]);
        return [
            "message" => " " . __('success_error.update_success'),
            "icon" => "check",
            "type" => "success",
        ];
    }
    public function buyItem($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = Functions::getCurrentStudent($class, []);

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
        if ($item->min_lvl > $student->level->number) {
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
        $student = Functions::getCurrentStudent($class, []);

        $new = Equipment::where('id', '=', request()->new)->firstOrFail();

        // $old = Equipment::where('id', '=', request()->old)->firstOrFail();
        $old = DB::table('equipment_student')
            ->join('equipment', 'equipment.id', 'equipment_student.equipment_id')
            ->where('equipment_student.student_id', '=', $student->id)
            ->where('equipment.type', '=', $new->type)
            ->select('*')
            ->first();

        // Avoid user mistakes
        if ($old->type != $new->type || $old->offset >= $new->offset || $new->character_id != $student->character_id || $student->equipment->contains($new->id)) {
            return [
                "message" => " " . __('success_error.shop_failed_exists'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        if ($new->price > $student->gold) {
            return [
                "message" => " " . __('success_error.shop_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        $gold = $student->gold - $new->price;
        $student->update(['gold' => $gold]);
        $student->equipment()->detach($old->id);
        $student->equipment()->attach($new->id);
        return [
            "message" => " " . __('success_error.shop_success'),
            "icon" => "check",
            "type" => "success",
            "equipment" => $student->fresh()->equipment,
            "boost" => $student->fresh()->getBoost(),
        ];
    }

    public function useItem($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $data = request()->validate([
            'id' => 'numeric',
            'itemId' => 'numeric',
        ]);

        $student = Functions::getCurrentStudent($class, []);
        
        if($student->hp <= 0)
            return false;
            
        $item = $student->items->where('id', '=', $data['itemId'])->first();

        if (!$item->pivot->count > 0)
            return false;

        if ($item->pivot->count == 1) {
            $student->items()->detach($item->id);
        } else
            $student->items()->updateExistingPivot($item->id, ['count' => $item->pivot->count - 1]);

        if ($item->hp > 0) {
            $student->setProperty('hp', $item->hp, true);
        }
        if ($item->xp > 0) {
            $student->setProperty('xp', $item->xp, true);
        }

        return ['xp' => $item->xp, 'hp' => $item->hp];
    }

    public function map($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        settings()->setExtraColumns(['user_id' => $class->id]);
        $activeMap = settings()->get('active_map');

        $map = Map::where('id', '=', $activeMap)->firstOrFail();
  
        $student = Functions::getCurrentStudent($class);
        return view('studentsview.map', compact('class', 'map', 'student'));
    }
}
