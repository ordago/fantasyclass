<?php

namespace App\Http\Controllers;

use App\ChallengesGroup;
use App\Classroom;

class ChallengesGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('view', $class);
        $challenges = ChallengesGroup::where('classroom_id', $class->id)->whereNull('challenges_group_id')->with('children')->get();
        return view('challenges.index', compact('class', 'challenges'));

    }
    public function destroy($id) {
        $group = ChallengesGroup::findOrFail($id);
        $class = Classroom::where('id', '=', $group->classroom_id)->firstorFail();
        $this->authorize('update', $class);
        if($group->challenges->count() == 0) {
            $group->delete();
        }
    }

    public function store($code) {
        $class = Classroom::where('code', '=', $code)->first();
        $this->authorize('update', $class);
        try {
            $data = request()->validate([
                'name' => ['string'],
                'icon' => ['string'],
                'id' => ['numeric', 'nullable'],
                'challenges_group_id' => ['numeric', 'nullable'],
            ]);

            $challenge = ChallengesGroup::create([
                'name' => $data['name'],
                'icon' => $data['icon'],
                'challenges_group_id' => $data['challenges_group_id'],
                'classroom_id' => $class->id,
            ]);
            $challenge['children'] = [];
            return [
                    "message" => __('success_error.add_success'),
                    "type" => "success",
                    "icon" => "check",
                    "challenge" => $challenge,
            ];

        }
        catch (\Throwable $th) {
            return [
                    "message" => __('success_error.error'),
                    "icon" => "times",
                    "type" => "error"
            ];
        }

    }

}
