<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Map;
use Illuminate\Http\Request;

class MapsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        
        
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $maps = $class->maps;
        dump($maps);
        return view('maps.index', compact('maps', 'class'));
    }

    public function create($code)
    {
        
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        return view('maps.create', compact('code', 'class'));
    }
}
