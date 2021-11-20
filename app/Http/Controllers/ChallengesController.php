<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\ChallengesGroup;
use App\Classroom;
use App\Evaluable;
use App\Group;
use App\Http\Classes\Functions;
use App\Student;
use GMP;
use Illuminate\Support\Facades\Crypt;
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

        foreach ($challenge->attachments as $attachment) {
            $newAttachment = $attachment->replicate();
            $newAttachment->challenge_id = $newChallenge->id;
            $newAttachment->push();
        }

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
        $challenges = Challenge::where('challenges_group_id', $group->id)->orWhereIn('challenges_group_id', $children)->with('attachments', 'comments', 'task')->get()->append('stats');

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
            'feedback' => ['string', 'nullable'],
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
            'dateend' => ['string', 'nullable'],
            'students' => ['array'],
            'items' => ['array', 'nullable'],
            'requirements' => ['array', 'nullable'],
            'challenge_required' => ['numeric', 'nullable'],
            'objects' => ['numeric', 'required'],
            'collectionables' => ['numeric', 'required'],
            'collection_id' => ['numeric', 'nullable'],
            'type_collectionable' => ['numeric', 'nullable'],
        ]);
    }

    public function getAllChallenges($code)
    {
        $class = Classroom::where('code', $code)->with(['challengeGroups.challenges' => function ($query) {
            $query->where('is_conquer', '1');
        }])->firstOrFail();
        $this->authorize('view', $class);
        $collections = collect();
        foreach ($class->collections as $collection) {
            if ($collection->collectionables->count() != 0)
                $collections->push($collection);
        }
        return ['challenges' => $class->challengeGroups, 'items' => $class->items, 'collections' => $collections];
    }

    public function getEvaluableInfo($code)
    {
        $class = Classroom::where('code', '=', $code)->first();
        $this->authorize('view', $class);
        $data = request()->validate([
            'evaluable' => ['numeric', 'required'],
            'grade' => ['numeric', 'required'],
        ]);

        $evaluable = Evaluable::findOrFail($data['evaluable']);
        $students = $evaluable->students()->where('grade', ">=", $data['grade'])->whereNull('from_student_id')->get()->pluck('id');
        return $students;

    }

    public function getChallengesInfo($code)
    {
        $class = Classroom::where('code', '=', $code)->first();
        $this->authorize('view', $class);

        $data = request()->validate([
            'challenge' => ['numeric'],
            'type' => ['numeric'],
        ]);

        $evaluables = $class->evaluables;

        if ($data['type'] == 0) {
            $challenge = Challenge::find($data['challenge']);
            $students = [];
            $students = $class->students()->whereNotIn('students.id', $challenge->students)->with(['items', 'challenges' => function ($query) use ($data) {
                $query
                    ->where('challenges.id', '=', $data['challenge']);
            }])->get();

            $students->each(function ($student) {
                if (!count($student->challenges)) {
                    $student->challenges->push(['pivot' => ['count' => null, 'evaluated' => 0, 'student_id' => $student->id]]);
                }
            });
            
            return ["students" => $students, "evaluables" => $evaluables];
        } else if ($data['type'] == 1) {
            $groups = $class->grouping()->first()->groups()->with(['challenges' => function ($query) use ($data) {
                $query->where('challenges.id', '=', $data['challenge']);
            }])->get();
            $groups->each(function ($group) {
                if (!count($group->challenges)) {
                    $group->challenges->push(['pivot' => ['count' => null, 'evaluated' => 0, 'group_id' => $group->id]]);
                }
            });
            return ["groups" => $groups];
        } else {
            return ["students" => $class->students()->get(), "evaluables" => $evaluables];
        }
    }

    public function toggleProp()
    {
        $data = request()->validate([
            'id' => ['numeric', 'required'],
            'prop' => ['string', 'required', "regex:(pinned)"],
        ]);

        $challenge = Challenge::where('id', '=', $data['id'])->first();
        $class = Classroom::where('id', '=', $challenge->classroom())->firstOrFail();
        $this->authorize('update', $class);

        $challenge->update(['pinned' => $challenge->pinned == 0 ? 1 : 0]);
    }

    public function getMapCode()
    {
        $data = request()->validate([
            'challenge' => ['numeric', 'required'],
        ]);

        $challenge = Challenge::findOrFail($data['challenge']);
        $class = Classroom::where('id', '=', $challenge->classroom())->firstOrFail();
        $this->authorize('view', $class);

        return "<iframe style='border: 0;' width='100%' src='" . env('APP_URL') . "/external/check/challengecheck/" . Functions::simple_crypt($class->code . ":" . $challenge->id) . "'></iframe>";
    }

    public function getChallengeLink()
    {
        $data = request()->validate([
            'challenge' => ['numeric', 'required'],
        ]);

        $challenge = Challenge::findOrFail($data['challenge']);
        $class = Classroom::where('id', '=', $challenge->classroom())->firstOrFail();
        $this->authorize('view', $class);

        return env('APP_URL') . "/external/challenges/" . Functions::simple_crypt($class->code . ":" . $challenge->id);
    }

    public function updateStudents()
    {
        $data = request()->validate([
            'challenge' => ['numeric', 'required'],
            'students' => ['array', 'required'],
        ]);
        $challenge = Challenge::where('id', '=', $data['challenge'])->firstOrFail();

        foreach ($data['students'] as $std) {
            $newInfo = $std['challenges'][0]['pivot'];
            $student = Student::findOrFail($std['challenges'][0]['pivot']['student_id']);
            $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
            $this->authorize('update', $class);
            $cards = [];
            $challenge_student = $student->challenges()->where('challenge_id', $challenge->id)->first();
            $mult = $newInfo['count'];
            if ($challenge_student) {
                 if ($challenge_student->pivot->count === $newInfo['count'])
                    continue;
                else if($challenge_student->pivot->count == $newInfo['count'])
                    $mult = 0;
                else if ($challenge_student->pivot->count > $newInfo['count'])
                    $mult = -1;
                else
                    $mult = 1;
            }
            // Update challenges in student
            if ($newInfo['count'] !== null) {
                $student->challenges()->sync([$challenge->id => ['count' => $newInfo['count']]], false);
            } else {
                $student->challenges()->detach($challenge->id);
            }
        
            if ($mult != 0) {
                if ($mult == 1) {
                    if ($challenge->auto_assign == 1) {
                        for ($i = 0; $i < $challenge->cards; $i++) {
                            array_push($cards, CardsController::getRandomCard($class->code));
                        }
                    }
                }
                $student->assignChallenge($challenge, $mult, $cards);
            }
        }
    }
    public function updateGroups()
    {
        $data = request()->validate([
            'challenge' => ['numeric', 'required'],
            'groups' => ['array', 'required'],
        ]);
        $challenge = Challenge::where('id', '=', $data['challenge'])->firstOrFail();

        foreach ($data['groups'] as $group) {
            $newInfo = $group['challenges'][0]['pivot'];
            $group = Group::where('id', $group['id'])->firstOrFail();
            $class = Classroom::where('id', '=', $group->grouping->classroom_id)->firstOrFail();
            $this->authorize('update', $class);

            $cards = [];
            $challenge_group = $group->challenges()->where('challenge_id', $challenge->id)->first();
            $mult = $newInfo['count'];
            if ($challenge_group) {
                 if ($challenge_group->pivot->count === $newInfo['count'])
                    continue;
                else if($challenge_group->pivot->count == $newInfo['count'])
                    $mult = 0;
                else if ($challenge_group->pivot->count > $newInfo['count'])
                    $mult = -1;
                else
                    $mult = 1;
            }


            // Update challenges in student
            if ($newInfo['count'] !== null) {
                $group->challenges()->sync([$challenge->id => ['count' => $newInfo['count']]], false);
            } else {
                $group->challenges()->detach($challenge->id);
            }
        
            if ($mult != 0) {
                if ($mult == 1) {
                    if ($challenge->auto_assign == 1) {
                        for ($i = 0; $i < $challenge->cards; $i++) {
                            array_push($cards, CardsController::getRandomCard($class->code));
                        }
                    }
                }
                // $student->assignChallenge($challenge, $mult, $cards);
                foreach ($group->students as $student) {
                    $student->assignChallenge($challenge, $mult, $cards);
                }
            }

        }
    }

    public function toggle()
    {
        $challenge = Challenge::where('id', '=', request()->challenge)->first();

        $data = request()->validate([
            'id' => ['numeric'],
            'force' => ['boolean'],
        ]);
        $cards = [];
        if ($challenge->type == 0) {
            $student = Student::where('id', '=', $data['id'])->first();
            $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
            $this->authorize('update', $class);
            if (!$data['force']) {
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
                $mult = 1;
                $attach = $student->challenges()->syncWithoutDetaching($challenge->id);
                if ($attach['attached']) {
                    if ($challenge->auto_assign == 1) {
                        for ($i = 0; $i < $challenge->cards; $i++) {
                            array_push($cards, CardsController::getRandomCard($class->code));
                        }
                    }
                    $student->assignChallenge($challenge, $mult, $cards);
                }
            }
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
        if ($mult)
            return [$challenge];
        else return [];
    }

    public function toggleDisable($id)
    {
        $challenge = Challenge::findOrFail($id);
        $class = Classroom::findOrFail($challenge->group->classroom_id);
        $this->authorize('update', $class);
        $challenge->update(['disabled' => !$challenge->disabled]);
    }

    public function store($code)
    {
        $data = $this->validateInput();
        $challengeGroup = ChallengesGroup::findOrFail(request()->challenges_group_id);
        $class = Classroom::where('id', '=', $challengeGroup->classroom_id)->first();
        $this->authorize('update', $class);
        try {
            $challenge = Challenge::create($data);

            return [
                "message" => __('success_error.add_success'),
                "type" => "success",
                "icon" => "check",
                "challenge" => $challenge,
            ];
        } catch (\Throwable $th) {
            return [
                "message" => __('success_error.error'),
                "icon" => "times",
                "type" => "error"
            ];
        }
    }
}
