<?php

namespace App\Http\Controllers;

use App\Classroom;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $settings = json_encode(["attendance_start" => settings()->get('attendance_start'), "attendance_end" => settings()->get('attendance_end')]);

        return view('attendance.index', compact('class', 'settings'));

    }
}
