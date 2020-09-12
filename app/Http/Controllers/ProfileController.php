<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Open user profile
     *
     */
    public function index()
    {
        
        $user = auth()->user();
        $profile = true;
        $lang = language()->allowed();
        return view('profile.index', compact('user', 'profile', 'lang'));
    }

    protected function promote()
    {
        $user = auth()->user();
        $user->update(['is_student' => 0]);
    }

    protected function update()
    {
        $user = auth()->user();

        $data = request()->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'current_password' => ['nullable', 'string'],
            'user_lang' => ['required', 'string', 'min:2', 'max:2'],
            'password' => ['nullable', 'string', 'min:8'],
            'email' => ['nullable', 'string', 'min:6'],
        ]);
        if ($data['password']) {
            if (Hash::check($data['current_password'], $user->password)) {
                $user->update([
                    'name' => $data['name'],
                    'locale' => $data['user_lang'],
                    'password' => Hash::make($data['password']),
                ]);
            } else {
                abort(403);
            }
        } else {
            $user->update([
                'name' => $data['name'],
                'locale' => $data['user_lang'],
            ]);
        }
        if($data['email'] != $user->email) {
            if (Hash::check($data['current_password'], $user->password)) {
                $user->update([
                    'email' => $data['email'],
                    'email_verified_at' => NULL,
                ]);
                $user->sendEmailVerificationNotification();
            } else abort(403);
            
        }
    }
}
