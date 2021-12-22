<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'name' => ['required', 'string', 'max:100'],
            'class' => ['required', 'string', 'max:10'],
        ]);

        Subject::create([
            'name' => $data['name'],
            'classroom_id' => $class->id,
            'class' => $data['class'],
        ]);
        return $class->fresh()->subjects;
    }

    public function destroy($code, $id) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);


        $subject = Subject::where('classroom_id', $class->id)->where('id', $id)->firstOrFail();
        DB::table('calevent_student')->whereIn('calevent_id', DB::table('calevents')->where('subject_id', $subject->id)->get()->pluck('id'))->delete();
        DB::table('calevents')->where('subject_id', $subject->id)->delete();
        $subject->delete();
        
    }
}
