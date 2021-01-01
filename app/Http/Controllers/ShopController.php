<?php

namespace App\Http\Controllers;

use App\Character;
use App\CharacterTheme;
use App\Classroom;
use App\Equipment;
use App\Item;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->with('items')->firstOrFail();
        $this->authorize('view', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $config = json_encode([
            'items_visibility' => settings()->get('items_visibility', false) ? true : false,
            'equipment_1_visibility' => settings()->get('equipment_1_visibility', false) ? true : false,
            'equipment_2_visibility' => settings()->get('equipment_2_visibility', false) ? true : false,
            'equipment_3_visibility' => settings()->get('equipment_3_visibility', false) ? true : false,
            'multiplier1' => (float) settings()->get('shop_multiplier_1', 1),
            'multiplier2' => (float) settings()->get('shop_multiplier_2', 1),
            'multiplier3' => (float) settings()->get('shop_multiplier_3', 1),
        ]);
        $character = null;
        if ($class->character_theme) {
            $character = CharacterTheme::find($class->character_theme)->with('characters')->first();
            $eq1 = $eq2 = $eq3 = null;

            foreach (Character::where('character_theme_id', $class->character_theme)->get() as $char) {
                $eq1[$char->id] = Equipment::where('character_id', '=', $char->id)->where('offset', '=', 1)->get();
                $eq2[$char->id] = Equipment::where('character_id', '=', $char->id)->where('offset', '=', 2)->get();
                $eq3[$char->id] = Equipment::where('character_id', '=', $char->id)->where('offset', '=', 3)->get();
            }

            $shop = [
                'eq1' => $eq1,
                'eq2' => $eq2,
                'eq3' => $eq3,
            ];
        } else $shop = null;
        $items = $class->items;

        return view('shop.index', compact('class', 'config', 'items', 'character', 'shop'));
    }

    public function create($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        return view('shop.create', compact('code', 'class'));
    }
    public function show($code, $id)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $item = Item::where('id', '=', $id)->where('classroom_id', '=', $class->id)->firstOrFail();
        return view('shop.create', compact('code', 'class', 'item'));
    }

    public function destroy($id)
    {
        $item = Item::where('id', '=', $id)->first();
        $class = Classroom::where('id', '=', $item->classroom_id)->first();
        $this->authorize('update', $class);
        try {
            $item->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }

    public function updateForSale($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'id' => 'numeric',
            'for_sale' => 'numeric',
        ]);

        $item = Item::where('id', '=', $data['id'])->where('classroom_id', '=', $class->id)->firstOrFail();
        $item->update($data);
    }
    public function update($code)
    {
        return $this->store($code, 'update');
    }

    public function store($code, $action = 'store')
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        try {

            $data = request()->validate([
                'id' => ['numeric', 'nullable'],
                'hp' => ['numeric', 'nullable'],
                'xp' => ['numeric', 'nullable'],
                'slot' => ['numeric', 'nullable'],
                'min_lvl' => ['numeric', 'nullable'],
                'price' => ['numeric', 'nullable'],
                'description' => ['string', 'nullable'],
                'icon' => ['image'],
            ]);

            $image = $data['icon'];
            $data['icon'] = '';
            $data['classroom_id'] = $class->id;

            if ($action == 'store')
                $item = Item::create($data);
            else {
                $item = Item::where('id', '=', $data['id'])->where('classroom_id', '=', $class->id)->firstOrFail();
                $item->update($data);
            }

            $item->addMedia(request()->file('icon'))
                ->toMediaCollection('item');

            $itemPath = $item->getMedia('item')->first();
            $imgPath = $itemPath->collection_name . "/" . $itemPath->uuid . '/' . $itemPath->file_name;
            $path = Storage::disk('public')->path('/') . $imgPath;
            if ($itemPath->mime_type != "image/gif" || $itemPath->size >= 500000) {
                Image::make($path)->resize(60, 60)->save();
            }

            $item->update(['icon' => '/storage/' . $imgPath]);
            $message = __('success_error.add_success');
            if ($action == 'update')
                $message = __('success_error.update_success');
            return [
                "message" => $message,
                "type" => "check",
                "type" => "success"
            ];
        } catch (\Throwable $th) {
            return [
                "message" => __('success_error.error'),
                "type" => "times",
                "type" => "error"
            ];
        }
    }
}
