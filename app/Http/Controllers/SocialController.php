<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function gclassroom()
    {
        $parameters = ['access_type' => 'offline'];
	    return Socialite::driver('google')->scopes([
            "https://www.googleapis.com/auth/classroom.courses.readonly",
            "https://www.googleapis.com/auth/classroom.rosters.readonly",
            ])->with($parameters)->redirect();
    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();

        if($user->refreshToken) {
            dd('Classroom');
        } else {
            dd('login');
        }

        $user = User::where('email', $user->email)->first();
        // $user = User::updateOrCreate(['email' => $auth_user->email], ['refresh_token' => $auth_user->token, 'name' => $auth_user->name]);

        
        if($user) {
            if(!$user->email_verified_at)
                $user->update(['email_verified_at' => now()]);
            Auth::login($user);
            return redirect()->to('/classroom/');
        } else {
            $errors = new MessageBag();
            // add your error messages:
            $errors->add('username', __('auth.provider_failed'));
            return redirect()->to('/login')->withErrors($errors);
        }
    }

}
