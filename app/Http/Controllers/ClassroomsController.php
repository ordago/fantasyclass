<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Queries;

class ClassroomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function create() {
        $bg = Queries::getBg();
        return view('classrooms.create', compact('bg'));
    }
    
    public function index() {
        $user = auth()->user();
        $bg = Queries::getBg();
        return view('classrooms.index', compact('user', 'bg'));
    }
}
