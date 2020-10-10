<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;
use App\Pet;

class PetsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function get() {
        
        $array = preg_grep('~\.(png)$~', scandir(public_path() . '/img/pets'));
        return json_encode($array);

    }

    public function update($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);
    
        $data = request()->validate([
            'pet.id' => ['numeric'],
            'pet.name' => ['nullable', 'string'],
            'pet.image' => ['required', 'string'],
            'pet.hp_boost' => ['numeric', 'required'],
            'pet.xp_boost' => ['numeric', 'required'],
            'pet.gold_boost' => ['numeric', 'required'],
            'pet.price' => ['numeric', 'required'],
        ]);

        $pet = Pet::find($data['pet']['id']);
        if($pet->classroom_id != $class->id)
            abort(403, 'What are you trying? :(');
        
        $pet->update($data['pet']);
    }

    public function store($code) {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'pet.name' => ['nullable', 'string'],
            'pet.image' => ['required', 'string'],
            'pet.hp_boost' => ['numeric', 'required'],
            'pet.xp_boost' => ['numeric', 'required'],
            'pet.gold_boost' => ['numeric', 'required'],
            'pet.price' => ['numeric', 'required'],
            'pet.for_sale' => ['boolean'],
        ]);
        $data['pet']['hp'] = 100;
        $data['pet']['classroom_id'] = $class->id;

        return Pet::create($data['pet']);

    }

    public function toggle($id) {
        $pet = Pet::where('id', '=', $id)->first();
        $class = Classroom::where('id', '=', $pet->classroom_id)->first();
        $this->authorize('update', $class);

        $pet->update([
            'for_sale' => $pet->for_sale ? 0 : 1,
        ]);
    }

    public function destroy($id) {

        $pet = Pet::where('id', '=', $id)->first();
        $class = Classroom::where('id', '=', $pet->classroom_id)->first();
        $this->authorize('update', $class);
        try {
            $pet->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;

    }

    public function index($code) {

        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $pets = $class->pets;

        return view('pets.index', compact('class', 'pets'));
    }

}
