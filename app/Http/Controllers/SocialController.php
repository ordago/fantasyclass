<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        session()->put('google_action', 'login');
        return Socialite::driver($provider)->redirect();
    }

    public function googleClassroom($code)
    {
        session()->put('code', $code);
        session()->put('google_action', 'classroom');
        if (!auth()->user())
            abort(403);
        $parameters = ['access_type' => 'offline'];
        return Socialite::driver('google')->scopes([
            'https://www.googleapis.com/auth/classroom.courses.readonly',
            "https://www.googleapis.com/auth/classroom.rosters.readonly",
            'https://www.googleapis.com/auth/classroom.profile.emails'
        ])->with($parameters)->redirect();
    }

    public function addGoogleDrive($code)
    {
        session()->put('code', $code);
        session()->put('google_action', 'drive');
        if (!auth()->user())
            abort(403);
        $parameters = ['access_type' => 'offline'];
        return Socialite::driver('google')->scopes([
            'https://www.googleapis.com/auth/drive.file',
        ])->with($parameters)->redirect();
    }

    public function unlinkGoogleClassroom()
    {
        auth()->user()->update(['token' => null, 'refresh_token' => null, 'expires_in' => null]);
    }

    public function callback($provider)
    {
        try {
            $auth_user = Socialite::driver($provider)->user();
        } catch (InvalidStateException $e) {
            $auth_user = Socialite::driver($provider)->stateless()->user();
            }
        $type = session()->pull('google_action');
        if ($type == "classroom") {
            auth()->user()->update(['refresh_token' => $auth_user->refreshToken, 'token' => $auth_user->token, 'expires_in' => $auth_user->expiresIn]);
            return redirect()->to('/classroom/' . session()->pull('code') . '/students/add/true');
        } else if ($type == "drive") {
            $user = Auth::user();
            $user->g_refresh_token = $auth_user->refreshToken;
            $user->g_token = $auth_user->token;
            $user->g_expires_in = $auth_user->expiresIn;
            $user->save();
            // ->update(['g_refresh_token' => $auth_user->refreshToken, 'g_token' => $auth_user->token, 'g_expires_in' => $auth_user->expiresIn]);
            return redirect()->to('/google/drive');
        } else {
            $user = User::where('email', $auth_user->email)->first();

            if ($user) {
                if (!$user->email_verified_at)
                    $user->update(['email_verified_at' => now()]);
                Auth::login($user, true);
                $redirect = session()->pull('url.previa');
                if(!$redirect)
                    $redirect = "/classroom";
                return redirect($redirect);
            } else {
                $errors = new MessageBag();
                $errors->add('username', __('auth.provider_failed'));
                return redirect()->to('/login')->withErrors($errors);
            }
        }
    }
}
