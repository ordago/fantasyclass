<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Evaluable;
use App\EvaluablesGroup;
use App\Rubric;
use App\Student;
use App\Tag;
use App\Exports\Export;
use App\Http\Classes\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public static function getEvalSettings($classId)
    {
        $settings = [];
        settings()->setExtraColumns(['classroom_id' => $classId]);
        $settings['eval_type'] = settings()->get('eval_type', 0);
        $settings['eval_max'] = settings()->get('eval_max', 10);
        $settings['eval_visible'] = settings()->get('eval_visible', false);
        return $settings;
    }

    public static function individualReport($class, $students, $eval)
    {
        if (!$eval) {
            $etags = Tag::where('classroom_id', $class->id)->whereNull('evaluables_group_id')->get();
        } else {
            $etags = $eval->tags;
        }

        $grades = collect();
        foreach ($students as $student) {
            $tags = collect();
            foreach ($etags as $tag) {
                $tags = $tags->push(['id' => $tag->id, 'name' => $tag->short, 'percent' => $tag->percent, 'evaluables' => collect()]);
            }
            foreach ($student->grades as $grade) {
                if ($grade->pivot->grade !== null) {
                    $evaluable = Evaluable::where('id', $grade->pivot->evaluable_id)->first();
                    foreach ($evaluable->tags as $evalTag) {
                        $tags->transform(function ($item, $key) use ($evalTag, $grade) {
                            if ($item['id'] == $evalTag->id) {
                                $evalTag->grade = $grade->pivot->grade;
                                $item['evaluables']->push($evalTag);
                            }
                            return ['id' => $item['id'], 'name' => $item['name'], 'percent' => $item['percent'], 'evaluables' => $item['evaluables']];
                        });
                    }
                }
            }
            $grades->push(['student_id' => $student->id, 'name' => $student->name, 'grades' => $tags]);
        }
        return $grades;
    }

    public function report($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $grades = collect();
        $students = $class->students;
        $grades->push(["namegroup" => __('evaluation.first'), "icon" => 'fas fa-chart-line', "evaluation" => EvaluationController::individualReport($class, $students, null)]);
        foreach ($class->evalgroups as $evalg) {
            $grades->push(["namegroup" => $evalg->name, "icon" => $evalg->icon, "evaluation" => EvaluationController::individualReport($class, $students, $evalg)]);
        }
        $settings = EvaluationController::getEvalSettings($class->id);

        return view('evaluation.report', compact('grades', 'class', 'settings'));
    }

    public function index($code)
    {
        $data = request()->validate([
            'id' => ['numeric']
        ]);
        if (isset($data['id'])) {
            $evaluableGroup = EvaluablesGroup::findOrFail($data['id']);
            $class = Classroom::where('id', $evaluableGroup->classroom_id)->firstOrFail();
        } else {
            $class = Classroom::where('code', $code)->firstOrFail();
        }
        $this->authorize('update', $class);

        if (isset($data['id'])) {
            $evaluables = Evaluable::where('evaluables_group_id', $evaluableGroup->id)->get();
            $evaluationlines = Evaluable::where('classroom_id', $class->id)->where('evaluables_group_id', $evaluableGroup->id)->with('tags')->get();
            $tags = Tag::where('classroom_id', $class->id)->where('evaluables_group_id', $evaluableGroup->id)->get();
        } else {
            $evaluables = Evaluable::whereNull('evaluables_group_id')->get();
            $evaluationlines = Evaluable::where('classroom_id', $class->id)->whereNull('evaluables_group_id')->with('tags')->get();
            $tags = Tag::where('classroom_id', $class->id)->whereNull('evaluables_group_id')->get();
        }

        $rubrics = Rubric::where('user_id', auth()->user()->id)->get();
        $settings = EvaluationController::getEvalSettings($class->id);

        return array('evaluables' => $evaluables, 'tags' => $tags, 'evaluationlines' => $evaluationlines, 'rubrics' => $rubrics, 'settings' => $settings);
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

        $settings = EvaluationController::getEvalSettings($class->id);

        return view('evaluation.grade', compact('class', 'evaluable', 'students', 'rubric', 'settings'));
    }
    public function evaluateRubric()
    {
        $data = request()->validate([
            'student' => ['numeric', 'required'],
            'rows' => ['array', 'required'],
            'evaluable' => ['numeric', 'required'],
        ]);

        $student = Student::findOrFail($data['student']);
        $class = Classroom::find($student->classroom->classroom_id);
        $this->authorize('update', $class);

        foreach ($data['rows'] as $row) {
            $find = DB::table('rubric_row_student')
                ->where('rubric_row_id', $row['0'])
                ->where('evaluable_id', $data['evaluable'])
                ->selectRaw('rubric_row_student.id')
                ->first();
            if ($find) {
                DB::table('rubric_row_student')
                    ->where('id', $find->id)
                    ->delete();
                 $student->rows()->attach(array($row['0'] => array('rubric_row_item_id' => $row['1'], 'evaluable_id' => $data['evaluable'])));
            } else {
                $student->rows()->attach(array($row['0'] => array('rubric_row_item_id' => $row['1'], 'evaluable_id' => $data['evaluable'])));
            }
        }
    }
    public function getShowRubric()
    {
        $data = request()->validate([
            'rubric' => ['numeric', 'required'],
        ]);

        $rubric = Rubric::find($data['rubric']);
        $rubric->load('rows.items');

        return $rubric;
    }

    public function getRubric()
    {
        $data = request()->validate([
            'student' => ['numeric', 'required'],
            'rubric' => ['numeric', 'required'],
            'evaluable' => ['numeric', 'required'],
        ]);

        $student = Student::find($data['student']);
        $class = Classroom::find($student->classroom->classroom_id);

        if (auth()->user()->id == $student->getUserId()) {
            $this->authorize('study', $class);
        } else {
            $this->authorize('update', $class);
        }

        $rubric = Rubric::find($data['rubric']);



        $rows = [];

        foreach ($rubric->rows as $row) {
            $rowQuery = $student->rows()->where('rubric_row_id', '=', $row->id)->where('evaluable_id', $data['evaluable'])->first();
            if(!$rowQuery)
                $rowQuery = $student->rows()->where('rubric_row_id', '=', $row->id)->first();
            if ($rowQuery) {
                $pivot = $rowQuery->pivot;
                $rows[] = [$pivot->rubric_row_id, $pivot->rubric_row_item_id];
            }
        }
        return $rows;
    }

    public function destroy($id)
    {
        $line = Evaluable::findOrFail($id);

        $class = Classroom::find($line->classroom->id);
        $this->authorize('update', $class);

        $line->delete();
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
            'evaluables_group_id' => ['nullable', 'numeric']
        ]);

        $evaluable = Evaluable::create([
            'description' => $data['description'],
            'type' => $data['type'],
            'rubric_id' => $data['rubric'],
            'classroom_id' => $class->id,
            'evaluables_group_id' => isset($data['evaluables_group_id']) ? $data['evaluables_group_id'] : null,
        ]);

        foreach ($data['tags'] as $tag) {
            $evaluable->tags()->attach([
                $tag['id'] => ['weight' => $data['weights'][$tag['id']]],
            ]);
        }
        $evaluable->load('tags');
        return $evaluable;
    }

    public function exportEvaluationReport(Request $request)
    {
        $headings = $request->get('headings');
        $values = $request->get('values');

        return Excel::download(new Export($headings, $values), 'Evaluation Report.xlsx');
    }
}
