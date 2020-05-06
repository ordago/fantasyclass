<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\GoalThemes;
use App\Theme;
use Illuminate\Http\Request;
use App\Http\Classes\Queries;

class ClassroomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:classroom'],
            'adventureName' => ['required', 'string', 'min:3', 'max:255'],
            'goalType' => ['required', 'integer'],
            'theme' => ['required', 'integer'],
            'charTheme' => ['required', 'integer'],
        ]);
    }

    public function store(Array $data) {
        return Classroom::create([
            'name' => $data['name'],
           // 'email' => $data['email'],
            //'username' => $data['username'],
            //'password' => Hash::make($data['password']),
        ]);
    }
    
    public function create() {
        $bg = Queries::getBg();
        $goals = GoalThemes::All();
        $themes = Theme::All();
        return view('classrooms.create', compact('bg', 'goals', 'themes'));
    }
    
    public function index() {
        $user = auth()->user();
        $bg = Queries::getBg();
        return view('classrooms.index', compact('user', 'bg'));
    }
}
