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
