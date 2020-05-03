<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Queries;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }
    public function index()
    {
        $bg = Queries::getBg();
        return view('home', compact('bg'));
    }
}
