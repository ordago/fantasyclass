<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Evaluable;
use App\Rubric;
use App\Student;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $tags = Tag::where('classroom_id', $class->id)->get();
        $rubrics = Rubric::where('user_id', auth()->user()->id)->get();
        $lines = Evaluable::where('classroom_id', $class->id)->with('tags')->get();
        return view('evaluation.index', compact('class', 'tags', 'rubrics', 'lines'));
    }

    public function evaluate($id)
    {
        $evaluable = Evaluable::findOrFail($id);
        $class = Classroom::where('id', $evaluable->classroom_id)->firstOrFail();
        $this->authorize('update', $class);

        foreach (request()->grades as $grades) {

            $student = Student::find($grades['id']);
            if ($student->classroom->classroom_id != $class->id)
                return false;

            $student->grades()->syncWithoutDetaching(array($evaluable->id => array('grade' => $grades['grade'], 'feedback' => $grades['feedback'])));
        }
    }
    public function grade($id)
    {
        $evaluable = Evaluable::findOrFail($id);
        $class = Classroom::where('id', $evaluable->classroom_id)->firstOrFail();
        $this->authorize('update', $class);

        $rubric = null;
        if ($evaluable->type == 1)
            $rubric = Rubric::where('id', $evaluable->rubric_id)->with('rows', 'rows.items')->first();

        $students = DB::table('students')
            ->join('classroom_user', 'students.classroom_user_id', 'classroom_user.id')
            ->leftJoin('evaluable_student', function ($join) use ($id) {
                $join->on('students.id', '=', 'evaluable_student.student_id')
                    ->where('evaluable_student.evaluable_id', '=', $id);
            })
            ->leftJoin('evaluables', function ($join) use ($id) {
                $join->on('evaluables.id', '=', 'evaluable_student.evaluable_id')
                    ->where('evaluables.id', '=', $id);
            })
            ->where('classroom_user.classroom_id', $class->id)
            ->selectRaw('students.id, students.name, evaluable_student.grade, evaluable_student.feedback')
            ->get();

        return view('evaluation.grade', compact('class', 'evaluable', 'students', 'rubric'));
    }
    public function evaluateRubric()
    {
        $data = request()->validate([
            'student' => ['numeric', 'required'],
            'rows' => ['array', 'required'],
        ]);

        $student = Student::findOrFail($data['student']);
        $class = Classroom::find($student->classroom->classroom_id);
        $this->authorize('update', $class);

        foreach ($data['rows'] as $row) {
            $student->rows()->syncWithoutDetaching(array($row['0'] => array('rubric_row_item_id' => $row['1'])));
        }
    }
    public function getRubric()
    {

        $data = request()->validate([
            'student' => ['numeric', 'required'],
            'rubric' => ['numeric', 'required'],
        ]);

        $student = Student::find($data['student']);
        $class = Classroom::find($student->classroom->classroom_id);
        $this->authorize('update', $class);
        $rubric = Rubric::find($data['rubric']);

        $rows = [];

        foreach ($rubric->rows as $row) {
            $rowQuery = $student->rows()->where('rubric_row_id', '=', $row->id)->first();
            if ($rowQuery) {
                $pivot = $rowQuery->pivot;
                $rows[] = [$pivot->rubric_row_id, $pivot->rubric_row_item_id];
            }
        }
        return $rows;
    }

    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'tags' => ['array', 'required'],
            'weights' => ['required'],
            'description' => ['required', 'string'],
            'type' => ['required', 'numeric'],
            'rubric' => ['nullable', 'numeric'],
        ]);

        $evaluable = Evaluable::create([
            'description' => $data['description'],
            'type' => $data['type'],
            'rubric_id' => $data['rubric'],
            'classroom_id' => $class->id,
        ]);

        foreach ($data['tags'] as $tag) {
            $evaluable->tags()->attach([
                $tag['id'] => ['weight' => $data['weights'][$tag['id']]],
            ]);
        }
    }
}
