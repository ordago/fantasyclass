<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Queries;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


    public function index()
    {
        if(env('CUSTOM') == 1) {
            return redirect('/login');
        }
        if(auth()->user()) {
            if(auth()->user()->username == "demo") {
                Auth::logout();
                return redirect('/');
            }
            return redirect('/classroom');
        }
        $locale = session('locale', 'es');
        App::setLocale($locale);
        return view('auth.home', compact('locale'));
    }

    public function cookies()
    {
        return view('auth.cookies');
    }

    public function policy()
    {
        return view('auth.policy');
    }
    
    public function locale($locale)
    {

        if (! in_array($locale, ['en', 'es', 'ca'])) {
            abort(404);
        }
        
        session(['locale' => $locale]);

        App::setLocale($locale);

        return redirect('/');

    }
}
