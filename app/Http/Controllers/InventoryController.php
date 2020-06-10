<?php

namespace App\Http\Controllers;

use App\Student;

class InventoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function update($code) {
        // $class = Classroom::where('code', '=', $code)->firstOrFail();
        $request = request();
        $student = Student::findOrFail($request->id);
        if($request->count <= 0) {
            $student->items()->detach($request->item_id);
        } else {
            $student->items()->sync([$request->item_id => ['count' => $request->count]], false);
        } 

    }

}
