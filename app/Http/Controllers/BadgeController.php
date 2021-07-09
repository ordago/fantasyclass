<?php

namespace App\Http\Controllers;

use App\Badge;
use App\Classroom;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class BadgeController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $badges = $class->badges;
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $style = settings()->get('badge_background', '/img/badges/badge_0.png');
        return view('badges.index', compact('badges', 'class', 'style'));
    }

    public function create($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $style = settings()->get('badge_background', '/img/badges/badge_0.png');
        return view('badges.create', compact('class', 'style'));
    }

    public function show($code, $id)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $badge = Badge::where('id', '=', $id)
            ->where('classroom_id', "=", $class->id)
            ->firstOrFail();
        return view('badges.create', compact('class', 'badge'));
    }

    // public function update($badge)
    // {
    //     $badge = Badge::findOrFail($badge);
    //     $class = Classroom::where('id', '=', $badge->classroom_id)->firstOrFail();
    //     $this->authorize('update', $class);
    // try {
    //     $badge->update($this->validateFormat(request()));
    //     return [
    //         "message" => __('success_error.update_success'),
    //         "type" => "success",
    //         "icon" => "check"
    //     ];
    // } catch (\Throwable $th) {
    //     return [
    //         "message" => __('success_error.error'),
    //         "type" => "times",
    //         "type" => "error"
    //     ];
    //     return $th;
    // }
    // }

    public function toggle()
    {
        $badge = Badge::find(request()->badge);
        $class = Classroom::where('id', '=', $badge->classroom_id)->firstOrFail();
        $this->authorize('update', $class);

        $student = Student::where('id', request()->student)->firstOrFail();
        if ($student->classroom->classroom_id != $class->id)
            return false;

        $result = $student->badges()->toggle($badge->id);
        $mult = 1;
        if ($result['detached'])
            $mult = -1;

        if ($badge->hp)
            $student->setProperty('hp', $badge->hp * $mult, true, 'badge');
        if ($badge->xp)
            $student->setProperty('xp', $badge->xp * $mult, true, 'badge');
        if ($badge->gold)
            $student->setProperty('gold', $badge->gold * $mult, true, 'badge');
        return [
            'hp' => $student->hp,
            'xp' => $student->xp,
            'gold' => $student->gold,
            'badges' => $student->badges
        ];
    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $data = $this->validateFormat(request());

        if (request()->id) {
            $badge = Badge::where('id', request()->id)->where('classroom_id', $class->id)->firstOrFail();
            try {
                $badge->update($data);
            } catch (\Throwable $th) {
                return [
                    "message" => __('success_error.error'),
                    "type" => "times",
                    "type" => "error"
                ];
                return $th;
            }
        } else {
            $badge = Badge::create($data);
            $class->badges()->save($badge);
        }


        if (request()->file('image') && request()->type == 1) {

            $badge->addMedia(request()->file('image'))
                ->toMediaCollection('badge');

            $itemPath = $badge->getMedia('badge')->first();
            $imgPath = $itemPath->collection_name . "/" . $itemPath->uuid . '/' . $itemPath->file_name;
            $path = Storage::disk('public')->path('/') . $imgPath;
            if ($itemPath->mime_type != "image/gif" || $itemPath->size >= 500000) {
                Image::make($path)->resize(80, 80)->save();
            }
            $badge->update(['image' => '/storage/' . $imgPath]);
        }

        $message = __('success_error.add_success');
        if (request()->id)
            $message = __('success_error.update_success');
        return [
            "message" => $message,
            "type" => "check",
            "type" => "success"
        ];

        return redirect('/classroom/' . $code . '/badges');
    }

    public function validateFormat($request)
    {
        return $request->validate([
            'icon' => ['nullable', 'string'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'numeric'],
            'xp' => ['required', 'numeric'],
            'hp' => ['required', 'numeric'],
            'gold' => ['required', 'numeric'],
            'image' => ['nullable'],
        ]);
    }

    public function destroy($id)
    {
        $badge = Badge::where('id', '=', $id)->first();
        $class = Classroom::where('id', $badge->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
            $badge->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }
}
