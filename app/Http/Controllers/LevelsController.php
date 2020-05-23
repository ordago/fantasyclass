<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Level;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class LevelsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $levels = $class->levels;
        
        return view('levels.index', compact('levels', 'class'));
    }

    public function store($code) {
    
        $class = DB::table('classrooms')->where('code', '=', $code)->pluck('id')->first();

        $data = request()->validate([
            'levels' => ['numeric'],
            'increment' => ['numeric'],
        ]);
        
        $exp = 0;
        for ($i=0; $i <= $data['levels']; $i++) { 
            Level::create([
                'number' => $i,
                'xp' => $exp,
                'classroom_id' => $class,
            ]);
            $exp += $data['increment'];
        }
        return back();
    }

    public function update($code, $level) {
        try {
            $lvl = Level::findOrFail($level);
            if(request()->file('file')) {
                $lvl->addMedia(request()->file('file'))
                ->toMediaCollection('level');
        
                   dump($lvl); 
                    $lvlPath = $lvl->getMedia('level')->first();
                    $imgPath = '/'.$lvlPath->id.'/'.$lvlPath->file_name;
                    $path = Storage::disk('public')->path('/').$imgPath;        
                    Image::make($path)->resize(128, 128)->save();
                }
                $lvl->update(request()->all());
                return [
                        "message" => __('success_error.update_success'),
                        "type" => "success",
                        "icon" => "check"
                ];
            
        } catch (\Throwable $th) {
            return [
                    "message" => __('success_error.error'),
                    "type" => "times",
                    "type" => "error"
            ];
            return $th;
        }
        
    }

    public function destroy($id) {
        try {
            Level::destroy($id);
        } catch (\Throwable $th) {
            return [ 'error' => $th];
        }
        return 1;
    }
}
