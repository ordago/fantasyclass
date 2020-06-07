<?php

namespace App\Http\Controllers;

use App\Classroom;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        return view('shop.index', compact('class'));
    }
}
