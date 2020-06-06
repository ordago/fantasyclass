<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
}
