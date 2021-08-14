<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Role;

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
