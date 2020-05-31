<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code){
       
        $class = Classroom::where('code', '=', $code)->with('grouping.groups')->firstorFail();
        return view('groups.index', compact('class'));
        
    }
    
    public function store($code) {
        $data = request()->validate([
            'groupsNumber' => ['numeric'],
        ]);

        $generator = new \Nubs\RandomNameGenerator\Alliteration();

        $groups = [];
        for ($i=0; $i < $data['groupsNumber']; $i++) {

            $groups[] = Group::create([
                'name' => $generator->getName(),
                'grouping_id' => 1,
            ]);

        }
        return $groups;

                
    }
}
