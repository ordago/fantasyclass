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
        $auth_user = Socialite::driver($provider)->user();
        $type = session()->pull('google_action');
        if ($type == "classroom") {
            auth()->user()->update(['refresh_token' => $auth_user->refreshToken, 'token' => $auth_user->token, 'expires_in' => $auth_user->expiresIn]);
            return redirect()->to('/classroom/' . session()->pull('code') . '/students/add/true');
        } else if ($type == "drive") {
            $class = Classroom::where('code', '=', session()->get('code'))->firstOrFail();
            settings()->setExtraColumns(['classroom_id' => $class->id]);
            settings()->set('gdrive_refresh_token', $auth_user->refreshToken);
            settings()->set('gdrive_token', $auth_user->token);
            settings()->set('expires_in', $auth_user->token);
            return redirect()->to('/classroom/' . session()->pull('code'));
        } else {
            $user = User::where('email', $auth_user->email)->first();

            if ($user) {
                if (!$user->email_verified_at)
                    $user->update(['email_verified_at' => now()]);
                Auth::login($user, true);
                return redirect()->to('/classroom/');
            } else {
                $errors = new MessageBag();
                $errors->add('username', __('auth.provider_failed'));
                return redirect()->to('/login')->withErrors($errors);
            }
        }
    }
}
