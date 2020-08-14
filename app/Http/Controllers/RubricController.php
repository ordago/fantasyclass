<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Rubric;
use App\RubricRow;
use App\RubricRowItem;
use Illuminate\Http\Request;

class RubricController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);
        $rubrics = Rubric::where('user_id', auth()->user()->id)->get();

        return view('rubric.index', compact('class', 'rubrics'));
    }
    public function create($code)
    {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        return view('rubric.create', compact('class'));
    }

    public function edit($code, $id)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $rubric = Rubric::where('id', $id)->with('rows', 'rows.items')->first();
        if ($rubric->user->classrooms->contains('id', $class->id)) {
            return view('rubric.edit', compact('class', 'rubric'));
        } else {
            abort(403);
        }
    }

    public function update($code, $id) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $rubric = Rubric::where('id', $id)->with('rows', 'rows.items')->first();
        if ($rubric->user->classrooms->contains('id', $class->id)) {
            $rubricRequest = request()->rubric;
            $rubric->update(['name' => $rubricRequest['name']]);

            foreach ($rubricRequest['rows'] as $row) {
                if(isset($row['id'])) {
                    $oldRow = RubricRow::where('id', $row['id'])->where('rubric_id', $rubric->id)->first();
                    $oldRow->update(['description' => $row['description'], 'optional' => $row['optional']]);
                } else {
                    $oldRow = RubricRow::create([
                        'rubric_id' => $rubric->id,
                        'description' => $row['description'],
                        'optional' => $row['optional']
                    ]);
                }
                foreach ($row['items'] as $item) {
                    if(isset($item['id'])) {
                        $oldItem = RubricRowItem::where('id', $item['id'])->where('rubric_row_id', $oldRow->id)->first();
                        $oldItem->update(['description' => $item['description'], 'points' => $item['points']]);
                    } else {
                        RubricRowItem::create([
                            'rubric_row_id' => $oldRow->id,
                            'description' => $item['description'],
                            'points' => $item['points']
                        ]);
                    }
                }
            }
        } else {
            abort(403);
        }
    }

    public function store($code)
    {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->rubric;

        $rubric = Rubric::create([
            'name' => $data['name'],
            'user_id' => auth()->user()->id,
        ]);

        foreach ($data['rows'] as $row) {
            $createdRow = RubricRow::create([
                'rubric_id' => $rubric->id,
                'description' => $row['description'],
                'optional' => $row['optional'],
            ]);

            foreach ($row['columns'] as $column) {
                RubricRowItem::create([
                    'rubric_row_id' => $createdRow->id,
                    'description' => $column['description'],
                    'points' => $column['points']
                ]);
            }
        }
    }
}
