<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NewPetNotification;
use App\Classroom;
use App\Pet;
use Illuminate\Support\Facades\Mail;

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

    public function get($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);
        
        $array = preg_grep('~\.(png)$~', scandir(public_path() . '/img/pets'));
        $array_craft = preg_grep('~\.(png)$~', scandir(public_path() . '/img/pets/craft'));
        $images[0] = $array;
        $images[1] = $class->getMedia('pets');
        $images[2] = $array_craft;
        return $images;

    }

    public function getSharedPets() {
        return Pet::where('shared', 1)->get();
    }

    public function importPet() {
        $data = request()->validate([
            'id' => ['required', 'numeric'],
            'code' => ['string', 'required'],
        ]);

        $class = Classroom::where('code', $data['code'])->firstOrFail();
        $this->authorize('update', $class);

        $pet = Pet::where('id', $data['id'])->where('shared', 1)->firstOrFail();
        Pet::create([
            'name' => $pet->name,
            'image' => $pet->image,
            'hp_boost' => $pet->hp_boost,
            'xp_boost' => $pet->xp_boost,
            'gold_boost' => $pet->gold_boost,
            'price' => $pet->price,
            'classroom_id' => $class->id,
        ]);

    }

    public function share() {
        $data = request()->validate([
            'id' => ['required', 'numeric'],
        ]);

        $pet = Pet::findOrFail($data['id']);
        $class = Classroom::where('id', $pet->classroom_id)->firstOrFail();
        $this->authorize('update', $class);

        $pet->update(['shared' => 1]);
        Mail::to(env('EMAIL'))->send(new NewPetNotification());

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
