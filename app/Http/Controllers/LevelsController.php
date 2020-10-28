<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Level;

class LevelsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $levels = $class->levels;

        return view('levels.index', compact('levels', 'class'));
    }

    public function createNew($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $level = Level::where('classroom_id', '=', $class->id)->max('number');

        $data = request()->validate([
            'xp' => ['numeric', 'required'],
        ]);

        return Level::create([
            'number' => $level + 1,
            'xp' => $data['xp'],
            'classroom_id' => $class->id,
        ]);
    }

    public function store($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'levels' => ['numeric'],
            'increment' => ['numeric'],
        ]);

        $exp = 0;
        for ($i = 0; $i <= $data['levels']; $i++) {
            Level::create([
                'number' => $i,
                'xp' => $exp,
                'classroom_id' => $class->id,
            ]);
            $exp += $data['increment'];
        }
        return back();
    }

    public function update($level)
    {
        $lvl = Level::findOrFail($level);
        $class = Classroom::where('id', '=', $lvl->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
            if (request()->logo) {
                $media = $lvl->addMedia(request()->file('logo'))
                    ->toMediaCollection('level');
                $lvl->update(['level' => $media->getUrl()]);
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

    public function destroy($id)
    {
        $lvl = Level::where('id', '=', $id)->first();
        $this->authorize('update', Classroom::where('id', $lvl->classroom_id)->firstOrFail());
        try {
            $lvl->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }
}
