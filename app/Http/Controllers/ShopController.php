<?php

namespace App\Http\Controllers;

use App\Classroom;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->with('items')->firstOrFail();
        settings()->setExtraColumns(['user_id' => $class->id]);
        $config = json_encode([
            'items_visibility' => settings()->get('items_visibility', false)? true: false,
            'equipment_1_visibility' => settings()->get('equipment_1_visibility', false)? true: false,
            'equipment_2_visibility' => settings()->get('equipment_2_visibility', false)? true: false,
            'equipment_3_visibility' => settings()->get('equipment_3_visibility', false)? true: false,
        ]);
        $items = $class->items;
        return view('shop.index', compact('class', 'config', 'items'));
    }
}
