<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\ClassroomUser;
use App\Equipment;
use App\Item;
use App\Student;
use Illuminate\Http\Request;

class ClassroomsStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function getCurrentStudent($class)
    {
        return Student::where('id', '=', auth()->user()->classrooms
            ->where('pivot.classroom_id', '=', $class->id)
            ->where('pivot.role', '=', 0)
            ->first()
            ->pivot
            ->student->id)->with(['equipment', 'classroom', 'behaviours', 'logEntries', 'items'])->first();
    }

    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->with('theme', 'characterTheme.characters')->firstOrFail();
        $admin = false;
        $student = $this->getCurrentStudent($class);

        // Shop information
        settings()->setExtraColumns(['user_id' => $class->id]);

        $items = $eq1 = $eq2 = $eq3 = null;
        if (settings()->get('items_visibility', false) ? true : false) {
            $items = Item::where('classroom_id', '=', $class->id)->where('for_sale', '=', '1')->get();
        }
        if (settings()->get('equipment_1_visibility', false) ? true : false) {
            $eq1 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 1)->get();
        }
        if (settings()->get('equipment_2_visibility', false) ? true : false) {
            $eq2 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 2)->get();
        }
        if (settings()->get('equipment_3_visibility', false) ? true : false) {
            $eq3 = Equipment::where('character_id', '=', $student->character_id)->where('offset', '=', 3)->get();
        }

        $shop = [
            'items' => json_encode($items),
            'eq1' => json_encode($eq1),
            'eq2' => json_encode($eq2),
            'eq3' => json_encode($eq3),
        ];

        return view('studentsview.show', compact('student', 'class', 'admin', 'shop'));
    }

    public function useItem($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $data = request()->validate([
            'id' => 'numeric',
            'itemId' => 'numeric',
        ]);

        $student = $this->getCurrentStudent($class);
        $item = $student->items->where('id', '=', $data['itemId'])->first();

        if (!$item->pivot->count > 0)
            return false;

        $student->items()->updateExistingPivot($item->id, ['count' => $item->pivot->count - 1]);
        if ($item->hp > 0) {
            $student->setProperty('hp', $item->hp);
        }
        if ($item->xp > 0) {
            $student->setProperty('xp', $item->xp);
        }

        return ['xp' => $item->xp, 'hp' => $item->hp];
    }
}
