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
            foreach ($student->grades->whereNull('from_student_id') as $grade) {
                if ($grade->pivot->from_student_id)
                    continue;
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
        $groups = $class->grouping->first()->groups;
        $rubrics = Rubric::where('user_id', auth()->user()->id)->get();
        $settings = EvaluationController::getEvalSettings($class->id);

        return array('groups' => $groups, 'evaluables' => $evaluables, 'tags' => $tags, 'evaluationlines' => $evaluationlines, 'rubrics' => $rubrics, 'settings' => $settings);
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

            $find = DB::table('evaluable_student')
                ->where('evaluable_id', $evaluable->id)
                ->where('student_id', $student->id)
                ->whereNull('from_student_id')
                ->selectRaw('evaluable_student.id')
                ->first();
            if ($find) {
                DB::table('evaluable_student')
                    ->where('id', $find->id)
                    ->delete();
            }
            $student->grades()->attach(array($evaluable->id => array('grade' => $grades['grade'], 'feedback' => $grades['feedback'])));
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
                    ->where('evaluable_student.evaluable_id', '=', $id)
                    ->whereNull('evaluable_student.from_student_id');
            })
            ->leftJoin('evaluables', function ($join) use ($id) {
                $join->on('evaluables.id', '=', 'evaluable_student.evaluable_id')
                    ->where('evaluables.id', '=', $id);
            })
            ->where('classroom_user.classroom_id', $class->id)
            ->selectRaw('students.id, students.name, evaluable_student.grade, evaluable_student.feedback')
            ->get();

        $evalinfo = [];
        if ($evaluable->subtype > 0) {
            foreach ($students as $student) {
                $average = DB::table('evaluable_student')
                    ->where('evaluable_id', $evaluable->id)
                    ->whereNotNull('from_student_id')
                    ->where('student_id', $student->id)
                    ->selectRaw('AVG(grade) as average')
                    ->get();
                $student->average = round($average[0]->average, 2);
            }
        }
        $settings = EvaluationController::getEvalSettings($class->id);

        return view('evaluation.grade', compact('class', 'evaluable', 'students', 'rubric', 'settings'));
    }
    public function evaluateRubric()
    {
        $data = request()->validate([
            'student' => ['numeric', 'required'],
            'from_student' => ['numeric', 'nullable'],
            'grade' => ['numeric', 'nullable'],
            'rows' => ['array', 'required'],
            'evaluable' => ['numeric', 'required'],
        ]);

        $student = Student::findOrFail($data['student']);
        $class = Classroom::find($student->classroom->classroom_id);
        $from = null;
        if (isset($data['from_student'])) {
            $this->authorize('studyOrTeach', $class);
            $from = $data['from_student'];
            $fromStudent = Student::findOrFail($from);
            if ($student->classroom->classroom_id != $fromStudent->classroom->classroom_id || ($student->groups->first() && $student->groups->first()->id != $fromStudent->groups->first()->id))
                abort(403);
            foreach ($data['rows'] as $row) {
                $find = DB::table('rubric_row_student')
                    ->where('rubric_row_id', $row['0'])
                    ->where('evaluable_id', $data['evaluable'])
                    ->where('student_id', $student->id)
                    ->where('from_student_id', $fromStudent->id)
                    ->selectRaw('rubric_row_student.id')
                    ->first();
                    if ($find) {
                        abort(403);
                    }
                    $student->rows()->attach(array($row['0'] => array('rubric_row_item_id' => $row['1'], 'evaluable_id' => $data['evaluable'], 'from_student_id' => $fromStudent->id)));
                }
                $student->grades()->attach(array($data['evaluable'] => array('grade' => $data['grade'], 'from_student_id' => $fromStudent->id)));
            } else {
                $this->authorize('update', $class);
                foreach ($data['rows'] as $row) {
                    $find = DB::table('rubric_row_student')
                    ->where('rubric_row_id', $row['0'])
                    ->where('student_id', $student->id)
                    ->where('evaluable_id', $data['evaluable'])
                    ->whereNull('from_student_id')
                    ->selectRaw('rubric_row_student.id')
                    ->first();
                if ($find) {
                    DB::table('rubric_row_student')
                        ->where('id', $find->id)
                        ->delete();
                }
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
            $admin = false;
        } else {
            $this->authorize('update', $class);
            $admin = true;
        }

        $rubric = Rubric::find($data['rubric']);
        $evaluable = Evaluable::find($data['evaluable']);

        $rows = [];
        $rowsStd = [];

        foreach ($rubric->rows as $row) {
            $rowQuery = $student->rows()->where('rubric_row_id', '=', $row->id)->where('evaluable_id', $data['evaluable'])->whereNull('from_student_id')->first();
            if (!$rowQuery)
                $rowQuery = $student->rows()->where('rubric_row_id', '=', $row->id)->whereNull('from_student_id')->first();
            if ($rowQuery) {
                $pivot = $rowQuery->pivot;
                $rows[] = [$pivot->rubric_row_id, $pivot->rubric_row_item_id];
            }

            if ($evaluable->subtype > 0) {
                $rowQuery = $student->rows()->where('rubric_row_id', '=', $row->id)->where('evaluable_id', $data['evaluable'])->whereNotNull('from_student_id')->get();
                if (!$rowQuery)
                    $rowQuery = $student->rows()->where('rubric_row_id', '=', $row->id)->whereNotNull('from_student_id')->get();
                if ($rowQuery) {
                    foreach ($rowQuery as $individual) {
                        $pivot = $individual->pivot;
                        $stdtmp = Student::find($pivot->from_student_id);
                        if ($admin)
                            $rowsStd[] = [$pivot->rubric_row_id, $pivot->rubric_row_item_id, ['avatar' => $stdtmp->avatar, 'name' => $stdtmp->name]];
                        else
                            $rowsStd[] = [$pivot->rubric_row_id, $pivot->rubric_row_item_id, ['avatar' => "/img/no_avatar.png", 'name' => '']];
                    }
                }
            }
        }

        $eval[0] = $rows;
        $eval[1] = $rowsStd;

        return $eval;
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
            'subtype' => ['required', 'numeric'],
            'rubric_id' => ['nullable', 'numeric'],
            'evaluables_group_id' => ['nullable', 'numeric']
        ]);

        $evaluable = Evaluable::create([
            'description' => $data['description'],
            'type' => $data['type'],
            'subtype' => $data['subtype'],
            'rubric_id' => $data['rubric_id'],
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
    public function update($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'id' => ['numeric', 'required'],
            'tags' => ['array', 'required'],
            'weights' => ['required'],
            'description' => ['required', 'string'],
            'type' => ['required', 'numeric'],
            'subtype' => ['required', 'numeric'],
            'rubric_id' => ['nullable', 'numeric'],
            'evaluables_group_id' => ['nullable', 'numeric']
        ]);

        $evaluable = Evaluable::where('id', $data['id'])->where('classroom_id', $class->id)->firstOrFail();
        $evaluable->update($data);
        $evaluable->tags()->sync([]);
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
