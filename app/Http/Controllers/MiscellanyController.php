<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use App\Http\Classes\Functions;
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
        if(!Auth::user()) {
            $text = explode(":", Functions::simple_crypt($code, "d"));
            $id = $text[1];
            $object = Challenge::where('id', $id)->with('attachments', 'comments')->first()->append('questioninfo');
            $class = Classroom::findOrFail($object->classroom());
            $permalink = env('APP_URL') . "/classroom/show/" . $class->code . "/challenges/" . $object->permalink;
            return view('maps.marker', compact('permalink'));
        }
        else return redirect("/external/".$type."/".$code);
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
