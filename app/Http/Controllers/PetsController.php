<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;

class PetsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        return view('pets.index', compact('class'));
    }

}
