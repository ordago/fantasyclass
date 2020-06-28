<?php

namespace App\Http\Controllers;

use App\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UtilsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function showMeter($code) {
        return view('utils.meter', compact('code'));
    }
    public function meter($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        foreach ($class->students as $student) {
            if(request()->hp != 0) {
                $student->setProperty('hp', request()->hp);
            }
            if(request()->xp != 0) {
                $student->setProperty('xp', request()->xp);
            }
            if(request()->gold != 0) {
                $student->setProperty('gold', request()->gold);
            }
        }
    }
    public function music()
    {
        $directory = "/music/";
        $music = [];
        // $sounds = glob($directory . "/*.*", GLOB_BRACE);

        $sounds = Storage::disk('music')->files();

        foreach ($sounds as $sound) {
            $soundName = explode('.', $sound)[0];
            $music[$soundName] = $sound;
        }
        return view('utils.music', compact('music'));
    }
}
