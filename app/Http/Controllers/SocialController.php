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
    public function callback($provider)
    {
            
        $getInfo = Socialite::driver($provider)->user();
        $user = User::where('email', $getInfo->email)->first();
        
        if($user) {
            Auth::login($user);
            return redirect()->to('/classrooms/');
        } else {
            $errors = new MessageBag();
            // add your error messages:
            $errors->add('username', __('auth.provider_failed'));
            return redirect()->to('/login')->withErrors($errors);
        }
    }

}
