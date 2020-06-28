<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\SettingsController;
use App\Map;
use Illuminate\Http\Request;

class MapsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();

        settings()->setExtraColumns(['user_id' => $class->id]);
        $activeMap = settings()->get('active_map');
        $maps = $class->maps;

        return view('maps.index', compact('maps', 'class', 'activeMap'));
    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $data = $this->validateFormat(request());

        $map = Map::create([
            'url' => $data['url'],
            'classroom_id' => $class->id,
            'name' => $data['name']
        ]);
        if (count($class->maps) == 1) {
            settings()->setExtraColumns(['user_id' => $class->id]);
            settings()->set('active_map', $map->id);
        }
        $class->maps()->save($map);
        return redirect('/classroom/' . $code . '/maps');
    }

    public function create($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        // $this->authorize('update', $class);
        return view('maps.create', compact('class'));
    }

    public function destroy($id)
    {
        $map = Map::where('id', '=', $id)->first();
        $class = Classroom::where('id', $map->classroom_id)->firstOrFail();
        //   $this->authorize('update', $class);
        try {
            $map->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }

    public function show($code, $id)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        //$this->authorize('view', $class);
        $map = Map::where('id', '=', $id)
            ->where('classroom_id', "=", $class->id)
            ->firstOrFail();
        return view('maps.create', compact('class', 'map'));
    }

    public function update($map)
    {
        $map = Map::findOrFail($map);
        $class = Classroom::where('id', '=', $map->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
            $map->update($this->validateFormat(request()));
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

    public function validateFormat($request)
    {
        return $request->validate([
            'url' => ['required', 'string'],
            'name' => ['required', 'string'],
        ]);
    }
}
