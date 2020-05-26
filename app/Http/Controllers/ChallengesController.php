<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\ChallengesGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChallengesController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {

        $data = request()->validate([
            'id' => ['numeric'],
        ]);

        $group = ChallengesGroup::findOrFail($data['id']);
        $children = ChallengesGroup::where('challenge_id' , $data['id'])->pluck('id')->toArray();
    
        
        return Challenge::where('challenges_groups_id', $group->id)->orWhereIn('challenges_groups_id', $children)->get();
    }

    public function store($code) {

        $class = DB::table('classrooms')->where('code', '=', $code)->pluck('id')->first();



        try {
                $data = request()->validate([
                    'title' => ['string'],
                    'icon' => ['string', 'nullable'],
                    'description' => ['string', 'nullable' ],
                    'content' => ['string', 'nullable'],
                    'is_conquer' => ['boolean'],
                    'xp' => ['numeric'],
                    'hp' => ['numeric'],
                    'gold' => ['numeric'],
                    'cards' => ['numeric'],
                    'auto_assign' => ['boolean'],
                    'optional' => ['boolean'],
                    'password' => ['string', 'nullable'],
                    'challenges_groups_id' => ['numeric'],
                    'datetime' => ['date'],
                ]);
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
