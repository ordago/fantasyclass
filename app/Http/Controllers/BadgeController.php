<?php

namespace App\Http\Controllers;

use App\Badge;
use App\Classroom;
use App\Student;
use Illuminate\Http\Request;

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
        return view('badges.index', compact('badges', 'class'));
    }

    public function create($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        return view('badges.create', compact('class'));
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

    public function update($badge)
    {
        $badge = Badge::findOrFail($badge);
        $class = Classroom::where('id', '=', $badge->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
            $badge->update($this->validateFormat(request()));
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

        $badge = Badge::create($data);
        $class->badges()->save($badge);
        return redirect('/classroom/' . $code . '/badges');
    }

    public function validateFormat($request)
    {
        return $request->validate([
            'icon' => ['required', 'string'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'xp' => ['required', 'numeric'],
            'hp' => ['required', 'numeric'],
            'gold' => ['required', 'numeric'],
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
