<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiscellanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function contribute()
    {
        return view('miscellany.contribute');
    }
}
