<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionableController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
}
