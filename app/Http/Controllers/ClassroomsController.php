<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\GoalThemes;
use App\Theme;
use Illuminate\Http\Request;
use App\Http\Classes\Queries;
use Illuminate\Support\Facades\Validator;

class ClassroomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store() {

        $data = request()->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'adventureName' => ['required', 'string', 'min:3', 'max:255'],
            'goalType' => ['required', 'integer'],
            'bgtheme' => ['required', 'integer'],
            'charTheme' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return redirect('/classrooms/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        Classroom::create([
            'name' => $data['name'],
            'name' => $data['name'],
            'name' => $data['name'],
            'name' => $data['name'],
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
