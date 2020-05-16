<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        }
    }

}
