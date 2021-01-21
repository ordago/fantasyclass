<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\DocumentCategory;
use Illuminate\Http\Request;

class DocumentManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
 
    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('view', $class);
        $documents = $class->documents()->orderBy('order')->get();
        return view('documents.index', compact('class', 'documents'));
    }

    public function store($code) {
        $class = Classroom::where('code', '=', $code)->first();
        $this->authorize('update', $class);
                $data = request()->validate([
                    'name' => ['string', 'required'],
                    'icon' => ['string', 'required'],
                ]);

                $category = DocumentCategory::create([
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'classroom_id' => $class->id,
                    'order' => $class->documents->count(),
                ]);
                return [
                        "message" => __('success_error.add_success'),
                        "type" => "success",
                        "icon" => "check",
                        "category" => $category,
                ];

    }

    public function destroy($id) {
        $group = DocumentCategory::findOrFail($id);
        $class = Classroom::where('id', '=', $group->classroom_id)->firstorFail();
        $this->authorize('update', $class);
        if($group->documents->count() == 0) {
            $group->delete();
        }        
    }
    public function order($code) {
        $class = Classroom::where('code', '=', $code)->first();
        $this->authorize('update', $class);
        
        $i = 0;
        foreach (request()->groups as $group) {
            $cat = DocumentCategory::where('classroom_id', $class->id)->where('id', $group['id'])->first();
            $cat->update(['order' => $i]);
            $i++;
        }
    }


}
