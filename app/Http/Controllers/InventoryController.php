<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Student;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function update() {
        $request = request();
        $student = Student::findOrFail($request->id);
        $class = Classroom::where('id', '=', $student->classroom->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        if($request->count <= 0) {
            $student->items()->detach($request->item_id);
        } else {
            $student->items()->sync([$request->item_id => ['count' => $request->count]], false);
        } 

    }

}
