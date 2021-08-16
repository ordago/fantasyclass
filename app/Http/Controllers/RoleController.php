<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Role;
use App\Student;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $roles = $class->roles;

        return view('roles.index', compact('roles', 'class'));
    }


    public function createNew($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        return Role::create([
            'classroom_id' => $class->id,
        ]);
    }

    public function removeAssign($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        foreach ($class->roles as $role) {
            $role->students()->sync([]);
        }
    }

    public function accept($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'roles' => ['array', 'required'],
        ]);

        $this->removeAssign($code);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $type = settings()->get('role_assign', 'classroom');


        if ($type == "classroom") {
            foreach ($data['roles'] as $roleId => $studenId) {
                if ($roleId) {
                    $role = Role::find($roleId);
                    if ($studenId) {
                        $student = Student::find($studenId);
                        if ($student->classroom->classroom_id != $class->id || $role->classroom_id != $class->id)
                            abort(403);
                        $student->role()->sync($roleId);
                    } else {
                        $role->students()->sync([]);
                    }
                }
            }
        } else {
            foreach ($data['roles'] as $group) {
                foreach ($group as $roleId => $studenId) {
                    if ($roleId) {
                        $role = Role::find($roleId);
                        $student = Student::find($studenId);
                        if ($student->classroom->classroom_id != $class->id || $role->classroom_id != $class->id)
                            abort(403);
                        $student->role()->sync($roleId);
                    }
                }
            }
        }
    }

    public function getRoleInfo($code)
    {
        $class = Classroom::where('code', '=', $code)->with('grouping.groups')->firstOrFail();
        $this->authorize('view', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $type = settings()->get('role_assign', 'classroom');

        $students = $class->students;
        $groups = $class->grouping->first()->groups;
        $groups->each->load('students');

        $roles = [];
        if ($type == "classroom")
            foreach ($class->roles as $role) {
                if ($role->students->first())
                    $roles[$role->id] = $role->students->first()->id;
            }
        else
            foreach ($groups as $group) {
                $roles[$group->id] = [];
                foreach ($class->roles as $role) {
                    foreach ($role->students as $student) {
                        if ($student->groups->first()->id == $group->id)
                            $roles[$group->id][$role->id] = $student->id;
                    }
                }
            }
        // dump($roles);
        // return response(['rooms' => array_values($rooms->toArray())]);
        return ["type" => $type, 'students' => $students, "roles" => collect($roles), 'groups' => $groups];
    }

    public function store($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'roles' => ['numeric', 'required'],
        ]);

        for ($i = 0; $i <= $data['roles']; $i++) {
            Role::create([
                'classroom_id' => $class->id,
            ]);
        }
        return back();
    }

    public function update($roleId)
    {
        $role = Role::findOrFail($roleId);
        $class = Classroom::where('id', '=', $role->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
            if (request()->logo) {
                $role->addMedia(request()->file('logo'))
                    ->toMediaCollection('role');
            }
            $role->update(request()->all());
            return [
                "message" => __('success_error.update_success'),
                "type" => "success",
                "icon" => "check"
            ];
        } catch (\Throwable $th) {
            return [
                "message" => __('success_error.error'),
                "type" => "times",
                "type" => "error"
            ];
        }
    }


    public function destroy($id)
    {
        $role = Role::where('id', '=', $id)->first();
        $this->authorize('update', Classroom::where('id', $role->classroom_id)->firstOrFail());
        try {
            $role->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }
}
