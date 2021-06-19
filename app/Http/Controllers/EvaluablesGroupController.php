<?php

namespace App\Http\Controllers;

use App\EvaluablesGroup;
use App\Classroom;

class EvaluablesGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('view', $class);
        $evaluablesGroup = EvaluablesGroup::where('classroom_id', $class->id)->get();
        return view('evaluation.index', compact('class', 'evaluablesGroup'));
    }

    public function destroy($id) {
        $evaluableGroup = EvaluablesGroup::findOrFail($id);
        $class = Classroom::where('id', '=', $evaluableGroup->classroom_id)->firstorFail();
        $this->authorize('update', $class);
        if($evaluableGroup->evaluables->count() == 0) {
            $evaluableGroup->delete();
        }
    }

    public function store($code) {
        $class = Classroom::where('code', '=', $code)->first();
        $this->authorize('update', $class);
        try {
            $data = request()->validate([
                'name' => ['string'],
                'icon' => ['string'],
                'id' => ['numeric', 'nullable'],
            ]);

            $evaluableGroup = EvaluablesGroup::create([
                'name' => $data['name'],
                'icon' => $data['icon'],
                'classroom_id' => $class->id,
            ]);

            return [
                    "message" => __('success_error.add_success'),
                    "type" => "success",
                    "icon" => "check",
                    "evaluable" => $evaluableGroup,
            ];
        }
        catch (\Throwable $th) {
            return [
                    "message" => __('success_error.error'),
                    "icon" => "times",
                    "type" => "error"
            ];
        }
    }
}
