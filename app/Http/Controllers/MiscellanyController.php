<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MiscellanyController extends Controller
{
    public function __construct()
    {
        // $this->middleware('verified');
    }

    public function contribute()
    {
        return view('miscellany.contribute');
    }

    public function externalCheck($type, $code)
    {
        if(!Auth::user())
            return view('maps.marker');
        else return redirect("/external/".$type."/".$code);
        // return view('miscellany.contribute');
    }

    public function mobile()
    {
        return view('utils.mobile');
    }
    
    public function demo()
    {
        $user = User::where('username', 'demo')->first();
        Auth::login($user, true);
        return redirect("/classroom");
    }
}
