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
       
        $class = Classroom::where('code', '=', $code)->with('grouping.groups', 'students.groups')->firstorFail();
        $this->authorize('view', $class);
        return view('groups.index', compact('class'));
        
    }

    public function update($code) {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);
        foreach (request()->dropGroups as $group) {
            $groupObj = Group::findOrFail($group['id']);
            if($groupObj->grouping->classroom_id != $class->id)
                continue;
            $groupObj->students()->detach($groupObj->students);
            foreach ($group['children'] as $std) {
                $groupObj->students()->attach($std['id']);
            }
        }
    }
    
    public function store($code) {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);
        $data = request()->validate([
            'groupsNumber' => ['numeric'],
        ]);

        $generator = new \Nubs\RandomNameGenerator\Alliteration();

        $groups = [];
        for ($i=0; $i < $data['groupsNumber']; $i++) {

            $groups[] = Group::create([
                'name' => $generator->getName(),
                'grouping_id' => $class->grouping->first()->id,
            ]);

        }
        return $groups;

                
    }
}
