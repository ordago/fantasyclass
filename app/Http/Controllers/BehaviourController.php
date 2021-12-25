<?php

namespace App\Http\Controllers;

use App\Behaviour;
use App\Classroom;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BehaviourController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $behaviours = $class->behaviours;
        return view('behaviours.index', compact('behaviours', 'class'));
    }

    // Add default cards
    public function importDefault($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        foreach (Behaviour::whereNull('classroom_id')->get() as $behaviour) {

            $newBehaviour = $behaviour->replicate();
            $class->cards()->save($newBehaviour);
        }
        return redirect('/classroom/' . $code . '/behaviours');
    }

    public function create($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        return view('behaviours.create', compact('class'));
    }

    public function show($code, $id)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $behaviour = Behaviour::where('id', '=', $id)
            ->where('classroom_id', "=", $class->id)
            ->firstOrFail();
        return view('behaviours.create', compact('class', 'behaviour'));
    }

    public function update($behaviour)
    {
        $behaviour = Behaviour::findOrFail($behaviour);
        $class = Classroom::where('id', '=', $behaviour->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
            $behaviour->update($this->validateFormat(request()));
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
            return $th;
        }
    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $data = $this->validateFormat(request());

        $behaviour = Behaviour::create($data);
        $class->behaviours()->save($behaviour);
        return redirect('/classroom/' . $code . '/behaviours');
    }
    public function addOrEditComment($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $data = request()->validate([
            'id' => ['numeric', 'required'],
            'student' => ['numeric', 'required'],
            'comment' => ['string', 'required'],
            'date' => ['date', 'required'],
        ]);

        $behaviour = Behaviour::where('classroom_id', $class->id)->where('id', $data['id'])->firstOrFail();
        $student = Student::findOrFail($data['student']);
        if ($student->classroom->classroom_id != $class->id)
            abort(403);

        DB::table('behaviour_student')
            ->where('behaviour_id', $behaviour->id)
            ->where('student_id', $student->id)
            ->where('created_at', $data['date'])
            ->update(['comment' => $data['comment']]);

        return $student->fresh()->behaviours;
    }

    public function validateFormat($request)
    {
        return $request->validate([
            'icon' => ['required', 'string'],
            'name' => ['required', 'string'],
            'custom_text' => ['nullable', 'string'],
            'xp' => ['required', 'numeric'],
            'hp' => ['required', 'numeric'],
            'gold' => ['required', 'numeric'],
        ]);
    }

    public function destroy($id)
    {
        $behaviour = Behaviour::where('id', '=', $id)->first();
        $class = Classroom::where('id', $behaviour->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
            $behaviour->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }
}
