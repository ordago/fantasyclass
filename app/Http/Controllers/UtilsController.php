<?php

namespace App\Http\Controllers;

use App\Behaviour;
use App\Classroom;
use App\Student;
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
    public function massive($code)
    {   
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $data = request()->validate([
            'behaviour' => ['numeric', 'required'],
            'students' => ['array', 'required'],
        ]);
        $behaviour = Behaviour::where('id', $data['behaviour'])->where('classroom_id', $class->id)->first();
        foreach ($data['students'] as $id) {
            $student = Student::find($id);
            if($student->classroom->classroom_id != $class->id)
                return abort('403');
            $student->addBehaviour($behaviour->id);
        }
    }
    public function iconPack($category)
    {
        $path = public_path() . '/img/icon-packs/' . $category;
        $images = array_diff(scandir($path), array('..', '.'));
        array_walk($images, function(&$value, $key) use ($category) { $value = '/img/icon-packs/' . $category . '/' . $value; } );      
        return json_encode($images);
    }

    public function iconPacks()
    {   
        $array = array_diff(scandir(public_path() . '/img/icon-packs'), array('..', '.'));
        return json_encode($array);
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
