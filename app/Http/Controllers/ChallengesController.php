<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\ChallengesGroup;
use App\Classroom;
use App\Group;
use App\Student;
use GMP;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ChallengesController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function uploadImage()
    {

        $path = request('file')->store('challenges', 'public');

        $image = Image::make(public_path("storage/{$path}"));
        if ($image->width() > 700) {
            $image->resize(700, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
        }
        return '/storage/' . $path;
    }

    public function index($code)
    {
        $data = request()->validate([
            'id' => ['numeric'],
        ]);
        $group = ChallengesGroup::findOrFail($data['id']);
        $class = Classroom::where('id', '=', $group->classroom_id)->first();
        $this->authorize('view', $class);

        $children = ChallengesGroup::where('challenges_group_id', $data['id'])->pluck('id')->toArray();
        $challenges = Challenge::where('challenges_group_id', $group->id)->orWhereIn('challenges_group_id', $children)->with('attachments', 'comments')->get()->append('stats');

        return $challenges;
    }

    public function destroy($id)
    {
        $challenge = Challenge::where('id', '=', $id)->first();
        $class = Classroom::where('id', '=', $challenge->group->classroom_id)->first();
        $this->authorize('update', $class);
        try {
            $challenge->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }

    public function update($code, $id)
    {
        $challenge = Challenge::findOrFail($id);
        $class = Classroom::where('id', '=', $challenge->group->classroom_id)->first();
        $this->authorize('update', $class);
        $challenge->update($this->validateInput());
        return [
            "message" => __('success_error.add_success'),
            "type" => "success",
            "icon" => "check",
            "challenge" => $challenge,
        ];
    }

    public function validateInput()
    {
        return request()->validate([
            'title' => ['string'],
            'icon' => ['string', 'nullable'],
            'color' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
            'completion' => ['numeric'],
            'content' => ['string', 'nullable'],
            'is_conquer' => ['boolean'],
            'xp' => ['numeric'],
            'hp' => ['numeric'],
            'gold' => ['numeric'],
            'cards' => ['numeric'],
            'auto_assign' => ['boolean'],
            'optional' => ['boolean'],
            'type' => ['boolean'],
            'password' => ['string', 'nullable'],
            'challenges_group_id' => ['numeric'],
            'datetime' => ['string'],
        ]);
    }

    public function getChallengesInfo($code)
    {
        $class = Classroom::where('code', '=', $code)->first();
        $this->authorize('view', $class);

        $data = request()->validate([
            'challenge' => ['numeric'],
            'type' => ['numeric'],
        ]);

        if ($data['type'] == 0) {
            $students = $class->students()->with(['challenges' => function ($query) use ($data) {
                $query->where('challenges.id', '=', $data['challenge']);
            }])->get();
            return $students;
        } else {
            $groups = $class->grouping()->first()->groups()->with(['challenges' => function ($query) use ($data) {
                $query->where('challenges.id', '=', $data['challenge']);
            }])->get();
            return $groups;
        }
    }

    public function toggle()
    {
        $challenge = Challenge::where('id', '=', request()->challenge)->first();
        
        $data = request()->validate([
            'id' => ['numeric'],
        ]);

        if($challenge->type == 0) {
            $student = Student::where('id', '=', $data['id'])->first();
            $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
            $this->authorize('update', $class);
            $result = $student->challenges()->toggle($challenge->id);
            $mult = 1;
            if ($result['detached']) {
                $mult = -1;
            } else {
                if($challenge->auto_assign == 1) {
                    $card = CardsController::getRandomCard($class->code);
                    $student->cards()->attach($card);
                }
            }
            $student->setProperty('hp', $mult * $challenge->hp);
            $student->setProperty('xp', $mult * $challenge->xp);
            $student->setProperty('gold', $mult * $challenge->gold);
        } else {
            $group = Group::where('id', $data['id'])->firstOrFail();
            $class = Classroom::where('id', '=', $group->grouping->classroom_id)->firstOrFail();
            $this->authorize('update', $class);
            $result = $group->challenges()->toggle($challenge->id);
            $mult = 1;
            $cards = true;
            if ($result['detached']) {
                $mult = -1;
                $card = false;
            }
            if($cards && $challenge->auto_assign == 1) {
                $card = CardsController::getRandomCard($class->code);
            }
            foreach ($group->students as $student) {
                $student->setProperty('hp', $mult * $challenge->hp);
                $student->setProperty('xp', $mult * $challenge->xp);
                $student->setProperty('gold', $mult * $challenge->gold);
                if($cards && $challenge->auto_assign == 1) {
                    $student->cards()->attach($card);
                }
            }
        }
    }

    public function store($code)
    {

        $data = $this->validateInput();
        $challengeGroup = ChallengesGroup::findOrFail(request()->challenges_group_id);
        $class = Classroom::where('id', '=', $challengeGroup->classroom_id)->first();
        $this->authorize('view', $class);
        try {
            $challenge = Challenge::create($data);

            return [
                "message" => __('success_error.add_success'),
                "type" => "success",
                "icon" => "check",
                "challenge" => $challenge,
            ];
        } catch (\Throwable $th) {
            dump($th);
            return [
                "message" => __('success_error.error'),
                "icon" => "times",
                "type" => "error"
            ];
            return $th;
        }
    }
}
