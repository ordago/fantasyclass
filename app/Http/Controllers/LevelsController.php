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
        $this->authorize('view', $class);
        $levels = $class->levels;
        
        return view('levels.index', compact('levels', 'class'));
    }
    
    public function store($code) {
        
        $class = DB::table('classrooms')->where('code', '=', $code)->first();
        $this->authorize('update', $class);
        
        $data = request()->validate([
            'levels' => ['numeric'],
            'increment' => ['numeric'],
            ]);
            
        $exp = 0;
        for ($i=0; $i <= $data['levels']; $i++) { 
            Level::create([
                'number' => $i,
                'xp' => $exp,
                'classroom_id' => $class->id,
                ]);
            $exp += $data['increment'];
        }
        return back();
    }
    
    public function update($level) {
        $lvl = Level::findOrFail($level);
        $class = DB::table('classrooms')->where('id', '=', $lvl->classroom_id)->first();
        $this->authorize('update', $class);
        try {
            if(request()->file('file')) {
                $lvl->addMedia(request()->file('file'))
                ->toMediaCollection('level');
        
                    $lvlPath = $lvl->getMedia('level')->first();
                    $imgPath = $lvlPath->collection_name . "/" . $lvlPath->id . '/' . $lvlPath->file_name;
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
        }
        
    }

    public function destroy($id) {
        $lvl = Level::where('id', '=', $id)->first();
        $this->authorize('update', Classroom::where('id', $lvl->classroom_id)->firstOrFail());
        try {
            $lvl->delete();
        } catch (\Throwable $th) {
            return [ 'error' => $th];
        }
        return 1;
    }
}
