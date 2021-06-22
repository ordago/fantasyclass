<?php

namespace App\Http\Controllers;

use App\Classroom;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $collections = $class->collections;

        return view('collections.index', compact('class', 'collections'));
    }
}
