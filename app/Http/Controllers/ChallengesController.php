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

    public function importChallenge($id)
    {
        $challenge = Challenge::findOrFail($id);
        $class = Classroom::findOrFail($challenge->classroom());
        $this->authorize('view', $class);

        $group = ChallengesGroup::findOrFail(request()->group);
        $class = Classroom::findOrFail($group->classroom_id);
        $this->authorize('update', $class);

        $newChallenge = $challenge->replicate();
        $newChallenge->challenges_group_id = $group->id;
        $newChallenge->students = [];
        $newChallenge->items = null;
        $newChallenge->requirements = null;
        $newChallenge->push();

        return $newChallenge;
    }

    public function getUserChallenges()
    {
        $user = auth()->user();
        $classrooms = $user->classrooms->where('pivot.role', '>=', 1);
        foreach ($classrooms as $class) {
            $class->load('challengeGroups.challenges');
        }
        return $classrooms;
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
            'students' => ['array'],
            'items' => ['array', 'nullable'],
            'requirements' => ['array', 'nullable'],
            'challenge_required' => ['numeric', 'nullable'],
        ]);
    }

    public function getAllChallenges($code)
    {
        $class = Classroom::where('code', $code)->with(['challengeGroups.challenges' => function ($query) {
            $query->where('is_conquer', '1');
        }])->firstOrFail();
        $this->authorize('view', $class);

        return ['challenges' => $class->challengeGroups, 'items' => $class->items];
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
            $challenge = Challenge::find($data['challenge']);
            $students = [];
            $students = $class->students()->whereNotIn('students.id', $challenge->students)->with(['items', 'challenges' => function ($query) use ($data) {
                $query
                    ->where('challenges.id', '=', $data['challenge']);
            }])->get();

            return $students;
        } else if ($data['type'] == 1) {
            $groups = $class->grouping()->first()->groups()->with(['challenges' => function ($query) use ($data) {
                $query->where('challenges.id', '=', $data['challenge']);
            }])->get();
            return $groups;
        } else {
            return $class->students()->get();
        }
    }

    public function toggle()
    {
        $challenge = Challenge::where('id', '=', request()->challenge)->first();

        $data = request()->validate([
            'id' => ['numeric'],
        ]);
        $cards = [];
        if ($challenge->type == 0) {
            $student = Student::where('id', '=', $data['id'])->first();
            $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
            $this->authorize('update', $class);
            $result = $student->challenges()->toggle($challenge->id);
            $mult = 1;
            if ($result['detached']) {
                $mult = -1;
            } else {
                if ($challenge->auto_assign == 1) {
                    for ($i = 0; $i < $challenge->cards; $i++) {
                        array_push($cards, CardsController::getRandomCard($class->code));
                    }
                }
            }
            $student->assignChallenge($challenge, $mult, $cards);
        } else {
            $group = Group::where('id', $data['id'])->firstOrFail();
            $class = Classroom::where('id', '=', $group->grouping->classroom_id)->firstOrFail();
            $this->authorize('update', $class);
            $result = $group->challenges()->toggle($challenge->id);
            $mult = 1;
            if ($result['detached']) {
                $mult = -1;
            } else {
                if ($challenge->auto_assign == 1) {
                    for ($i = 0; $i < $challenge->cards; $i++) {
                        array_push($cards, CardsController::getRandomCard($class->code));
                    }
                }
            }
            foreach ($group->students as $student) {
                $student->assignChallenge($challenge, $mult, $cards);
            }
        }
    }

    public function store($code)
    {
        $data = $this->validateInput();
        $challengeGroup = ChallengesGroup::findOrFail(request()->challenges_group_id);
        $class = Classroom::where('id', '=', $challengeGroup->classroom_id)->first();
        $this->authorize('update', $class);
        $data['students'] = json_encode($data['students']);
        $data['items'] = json_encode($data['items']);
        $data['requirements'] = json_encode($data['requirements']);
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
        }
    }
}
