<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class PreferencesController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Open user preferences
     *
     */
    public function index()
    {
        $user = auth()->user();
        return view('preferences.index', compact('user'));
    }

    protected function update()
    {
        $user = auth()->user();
        
        $data = request()->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        auth()->user()->update([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect('/preferences');
        // language()->back($code)
    }
}
