<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassroomsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function create() {
        return view('classrooms.create');
    }

    public function index() {
        $user = auth()->user();
        return view('classrooms.index', compact('user'));
    }
}
