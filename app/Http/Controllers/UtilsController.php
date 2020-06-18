<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UtilsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
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
