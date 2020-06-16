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

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->with('grouping.groups', 'students.groups')->firstorFail();
        $this->authorize('view', $class);
        return view('groups.index', compact('class'));
    }

    public function update($code, $type)
    {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);

        if ($type == 'students') {
            foreach (request()->dropGroups as $group) {
                $groupObj = Group::findOrFail($group['id']);
                if ($groupObj->grouping->classroom_id != $class->id)
                    continue;
                $groupObj->students()->detach($groupObj->students);
                foreach ($group['children'] as $std) {
                    $groupObj->students()->attach($std['id']);
                }
            }
        } else if ($type == 'info') {
            $data = request()->validate([
                'id' => ['numeric'],
                'name' => ['string'],
                'logo' => ['image', 'nullable'],
            ]);

            $group = Group::find($data['id']);
            $class = Classroom::where('id', '=', $group->grouping->classroom_id)->firstOrFail();
            $this->authorize('update', $class);

            if (request()->logo) {
                $media = $group->addMedia(request()->file('logo'))
                    ->toMediaCollection('logo');
                dump($media->getUrl());
                $group->update(['logo' => $media->getUrl()]);
            } 
            $group->update(['name' => $data['name']]);
        }
    }

    public function destroy($id) {
        $group = Group::find($id);
        dump($id);
        $this->authorize('update', Classroom::where('id', $group->grouping->classroom_id)->firstOrFail());
        try {
            $group->delete();
        } catch (\Throwable $th) {
            return [ 'error' => $th];
        }
        return 1;
    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);
        $data = request()->validate([
            'groupsNumber' => ['numeric'],
        ]);

        $generator = new \Nubs\RandomNameGenerator\Alliteration();

        $groups = [];
        for ($i = 0; $i < $data['groupsNumber']; $i++) {

            $groups[] = Group::create([
                'name' => $generator->getName(),
                'grouping_id' => $class->grouping->first()->id,
            ]);
        }
        return $groups;
    }
}
