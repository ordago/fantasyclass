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

        return view('attendance.index', compact('class'));

    }
}
