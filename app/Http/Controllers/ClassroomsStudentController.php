<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use App\Equipment;
use App\Item;
use App\Student;
use App\User;
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

    public function getCurrentStudent($class)
    {
        return Student::where('id', '=', auth()->user()->classrooms
            ->where('pivot.classroom_id', '=', $class->id)
            ->where('pivot.role', '=', 0)
            ->first()
            ->pivot
            ->student->id)->with(['equipment', 'classroom', 'behaviours', 'logEntries', 'items'])->first();
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
            $student = $this->getCurrentStudent($class);
        }

        $student->addMedia(request()->file('avatar'))
            ->toMediaCollection('avatar');

        $avatarPath = $student->getMedia('avatar')->first();
        $imgPath = $avatarPath->collection_name . "/" . $avatarPath->id . '/' . $avatarPath->file_name;
        $path = Storage::disk('public')->path('/') . $imgPath;
        Image::make($path)->resize(128, 128)->save();
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->with('students.equipment', 'theme')->firstOrFail();

        $student = $this->getCurrentStudent($class);

        $students = $class->students->map(function ($user) {
            return collect($user->toArray())
                ->only(['avatar', 'name', 'xp', 'hp', 'gold', 'equipment', 'level'])
                ->all();
        });

        return view('studentsview.index', compact('class', 'student', 'students'));
    }

    public function stories($code)
    {
        $class = Classroom::where('code', '=', $code)->with('challengeGroups')->firstOrFail();

        $student = $this->getCurrentStudent($class);
        $stories = null;

        foreach ($class->challengeGroups as $group) {

            // TODO Avoid duplicate code
            if (!$stories) {
                $stories = $group->challenges->where('datetime', '<=', Carbon::now()->toDateTimeString())->map(function ($challenge) {
                    return collect($challenge->toArray())
                        ->only(['title', 'xp', 'hp', 'gold', 'datetime', 'content', 'icon', 'color', 'is_conquer', 'cards'])
                        ->all();
                });
            } else {
                $stories = $stories->merge($group->challenges->where('datetime', '<=', Carbon::now()->toDateTimeString())->map(function ($challenge) {
                    return collect($challenge->toArray())
                        ->only(['title', 'xp', 'hp', 'gold', 'datetime', 'content', 'icon', 'color', 'is_conquer', 'cards'])
                        ->all();
                }));
            }
        }
        return view('studentsview.stories', compact('class', 'student', 'stories'));
    }

    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'characterTheme.characters')->firstOrFail();
        $admin = false;
        $student = $this->getCurrentStudent($class);

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

        return view('studentsview.show', compact('student', 'class', 'admin', 'shop', 'challenges'));
    }

    public function markChallenge($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = $this->getCurrentStudent($class);

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
            $student->setProperty('hp', $challenge->hp);
            $student->setProperty('xp', $challenge->xp);
            $student->setProperty('gold', $challenge->gold);
        }
        return [
            'success' => true,
            'hp' => $student->hp,
            'xp' => $student->xp,
            'gold' => $student->gold,
        ];
    }

    public function buyItem($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = $this->getCurrentStudent($class);

        $data = request()->validate([
            'item' => 'numeric',
        ]);

        $item = Item::where('id', '=', $data['item'])->where('classroom_id', '=', $class->id)->where('for_sale', '=', '1')->firstOrFail();
        $studentItem = $student->items->where('id', $item->id)->first();

        if ($item->price > $student->gold) {
            return [
                "message" => " " . __('shop.equipment_failed_money'),
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
            "message" => " " . __('shop.equipment_succes'),
            "icon" => "check",
            "type" => "success",
            "items" => $student->fresh()->items,
        ];
    }
    public function buyEquipment($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = $this->getCurrentStudent($class);

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
                "message" => " " . __('shop.equipment_failed_exists'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        if ($new->price > $student->gold) {
            return [
                "message" => " " . __('shop.equipment_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        $gold = $student->gold - $new->price;
        $student->update(['gold' => $gold]);
        $student->equipment()->detach($old->id);
        $student->equipment()->attach($new->id);
        return [
            "message" => " " . __('shop.equipment_succes'),
            "icon" => "check",
            "type" => "success",
            "equipment" => $student->fresh()->equipment,
        ];
    }

    public function useItem($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $data = request()->validate([
            'id' => 'numeric',
            'itemId' => 'numeric',
        ]);

        $student = $this->getCurrentStudent($class);
        $item = $student->items->where('id', '=', $data['itemId'])->first();

        if (!$item->pivot->count > 0)
            return false;

        if ($item->pivot->count == 1) {
            $student->items()->detach($item->id);
        } else
            $student->items()->updateExistingPivot($item->id, ['count' => $item->pivot->count - 1]);

        if ($item->hp > 0) {
            $student->setProperty('hp', $item->hp);
        }
        if ($item->xp > 0) {
            $student->setProperty('xp', $item->xp);
        }

        return ['xp' => $item->xp, 'hp' => $item->hp];
    }
}
