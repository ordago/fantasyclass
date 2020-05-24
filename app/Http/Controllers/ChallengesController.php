<?php

namespace App\Http\Controllers;

use App\ChallengesGroup;
use App\Classroom;
use Illuminate\Support\Facades\DB;

class ChallengesController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $challenges = ChallengesGroup::where('classroom_id', $class->id)->whereNull('challenge_id')->with('children')->get();
        return view('challenges.index', compact('class', 'challenges'));

    }
    public function store($code) {
        $class = DB::table('classrooms')->where('code', '=', $code)->pluck('id')->first();
        try {
                $data = request()->validate([
                    'name' => ['string'],
                    'icon' => ['string'],
                    'id' => ['numeric', 'nullable'],
                    'challenge_id' => ['numeric', 'nullable'],
                ]);

                $challenge = ChallengesGroup::create([
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'challenge_id' => $data['challenge_id'],
                    'classroom_id' => $class,
                ]);

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
