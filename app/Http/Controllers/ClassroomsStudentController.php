<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Equipment;
use App\Item;
use App\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


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

    public function updateavatar($code) {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
 
        $data = request()->validate([
            'avatar' => ['image'],
        ]);

        $student = $this->getCurrentStudent($class);

        $student->addMedia(request()->file('avatar'))
                ->toMediaCollection('avatar');

        $avatarPath = $student->getMedia('avatar')->first();
        $imgPath = '/' . $avatarPath->id . '/' . $avatarPath->file_name;
        $path = Storage::disk('public')->path('/') . $imgPath;
        Image::make($path)->resize(128, 128)->save();

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

    public function buyItem($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = $this->getCurrentStudent($class);

        $data = request()->validate([
            'item' => 'numeric',
        ]);

        $item = Item::where('id', '=', $data['item'])->where('classroom_id', '=', $class->id)->where('for_sale', '=', '1')->firstOrFail();
        $studentItem = $student->items->where('id', $item->id)->first();

        if ($item->price > $student->gold) {
            return [
                "message" => " " . __('shop.equipment_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }

        if ($studentItem)
            $count = $studentItem->pivot->count + 1;
        else $count = 1;
        

        $student->items()->sync([$item->id => ['count' => $count]], false);
        $student->update(['gold' => ($student->gold - $item->price)]);

        dump($student->items);
        return [
            "message" => " " . __('shop.equipment_succes'),
            "icon" => "check",
            "type" => "success",
            "items" => $student->fresh()->items,
        ];
    }
    public function buyEquipment($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $student = $this->getCurrentStudent($class);

        $new = Equipment::where('id', '=', request()->new)->firstOrFail();

        // $old = Equipment::where('id', '=', request()->old)->firstOrFail();
        $old = DB::table('equipment_student')
            ->join('equipment', 'equipment.id', 'equipment_student.equipment_id')
            ->where('equipment_student.student_id', '=', $student->id)
            ->where('equipment.type', '=', $new->type)
            ->select('*')
            ->first();

        // Avoid user mistakes
        if ($old->type != $new->type || $old->offset >= $new->offset || $new->character_id != $student->character_id || $student->equipment->contains($new->id)) {
            return [
                "message" => " " . __('shop.equipment_failed_exists'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        if ($new->price > $student->gold) {
            return [
                "message" => " " . __('shop.equipment_failed_money'),
                "icon" => "sad-tear",
                "type" => "error"
            ];
        }
        $gold = $student->gold - $new->price;
        $student->update(['gold' => $gold]);
        $student->equipment()->detach($old->id);
        $student->equipment()->attach($new->id);
        return [
            "message" => " " . __('shop.equipment_succes'),
            "icon" => "check",
            "type" => "success",
            "equipment" => $student->fresh()->equipment,
        ];
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

        if ($item->pivot->count == 1) {
            $student->items()->detach($item->id);
        } else
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
