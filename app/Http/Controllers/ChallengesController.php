<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\ChallengesGroup;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ChallengesController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function uploadImage() {
        
       $path = request('file')->store('challenges', 'public');
       
        $image = Image::make(public_path("storage/{$path}"));
        if($image->width() > 700) {
            $image->resize(700 , null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
        }
       return '/storage/'.$path;
    
    }

    public function index($code) {

        $data = request()->validate([
            'id' => ['numeric'],
        ]);

        $group = ChallengesGroup::findOrFail($data['id']);
        $children = ChallengesGroup::where('challenges_group_id' , $data['id'])->pluck('id')->toArray();
        return Challenge::where('challenges_group_id', $group->id)->orWhereIn('challenges_group_id', $children)->get();
    }

    public function destroy($code, $id) {
        try {
            Challenge::destroy($id);
        } catch (\Throwable $th) {
            return [ 'error' => $th];
        }
        return 1;
    }

    public function update($code, $id) {
        $challenge = Challenge::findOrFail($id)->first();
        $challenge->update($this->validateInput());
        return [
            "message" => __('success_error.add_success'),
            "type" => "success",
            "icon" => "check",
            "challenge" => $challenge,
    ];
    }

    public function validateInput() {
        return request()->validate([
            'title' => ['string'],
            'icon' => ['string', 'nullable'],
            'color' => ['string', 'nullable'],
            'description' => ['string', 'nullable' ],
            'completion' => ['numeric'],
            'content' => ['string', 'nullable'],
            'is_conquer' => ['boolean'],
            'xp' => ['numeric'],
            'hp' => ['numeric'],
            'gold' => ['numeric'],
            'cards' => ['numeric'],
            'auto_assign' => ['boolean'],
            'optional' => ['boolean'],
            'password' => ['string', 'nullable'],
            'challenges_group_id' => ['numeric'],
            'datetime' => ['string'],
        ]);
    }

    public function store($code) {

        $class = DB::table('classrooms')->where('code', '=', $code)->pluck('id')->first();
        try {
                $data = $this->validateInput();
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
