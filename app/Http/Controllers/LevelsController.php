<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Level;
use App\LevelGroup;
use App\LevelShared;
use App\Mail\NewLevelsNotification;
use Illuminate\Support\Facades\Mail;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    public function importLevels()
    {
        $data = request()->validate([
            'code' => ['string', 'required'],
            'id' => ['numeric', 'required'],
        ]);
        $class = Classroom::where('code', $data['code'])->firstOrFail();
        $this->authorize('update', $class);
        $class->levels()->delete();
        $levelg = LevelGroup::where('id', $data['id'])->with('levels')->firstOrFail();
        foreach ($levelg->levels as $levels) {
            $newLvl = Level::create([
                'number' => $levels->number,
                'xp' => $levels->xp,
                'title' => $levels->title,
                'description' => $levels->description,
                'classroom_id' => $class->id,
            ]);
            $levels->media->each(function (Media $media) use ($newLvl) {
                $props = $media->toArray();
                unset($props['uuid']);
                unset($props['id']);
                $props['collection_name'] = 'level';
                $newLvl->addMedia($media->getPath())
                    ->preservingOriginal()
                    ->withProperties($props)
                    ->toMediaCollection($media->collection_name);
            });
        }
    }

    public function getSharedLevels()
    {
        $levels = LevelGroup::all();
        $levels->each->load('levels');
        return $levels;
    }

    public function share()
    {
        $data = request()->validate([
            'code' => ['required', 'string'],
            'name' => ['required', 'string'],
        ]);

        $class = Classroom::where('code', '=', $data['code'])->firstOrFail();
        $this->authorize('update', $class);

        $lvlgroup = LevelGroup::create([
            'name' => $data['name'],
        ]);
        foreach ($class->levels as $level) {
            $newLvl = LevelShared::create([
                'number' => $level->number,
                'xp' => $level->xp,
                'title' => $level->title,
                'description' => $level->description,
                'level_group_id' => $lvlgroup->id,
            ]);
            $level->media->each(function (Media $media) use ($newLvl) {
                $props = $media->toArray();
                unset($props['uuid']);
                unset($props['id']);
                $newLvl->addMedia($media->getPath())
                    ->preservingOriginal()
                    ->withProperties($props)
                    ->toMediaCollection($media->collection_name);
            });
        }

        Mail::to(env('EMAIL'))->send(new NewLevelsNotification());
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
