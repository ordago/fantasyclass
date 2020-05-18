<?php

namespace App\Http\Controllers;

use App\Card;
use App\Classroom;
use Spatie\Image\Image;
use Illuminate\Http\Request;

class CardsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $cards = $class->cards->sortBy('type');
        return view('cards.index', compact('class', 'cards'));
    }

    public function create($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        return view('cards.create', compact('class'));
    }

    public function store($code) {
        $data = request()->validate([
            'width' => ['required', 'numeric'],
            'marginTop' => ['required', 'numeric'],
            'marginLeft' => ['required', 'numeric'],
            'title' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
            'bgType' => ['required', 'numeric'],
            'radius' => ['required', 'numeric'],
            'minLvl' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
            'xp' => ['required', 'numeric'],
            'gold' => ['required', 'numeric'],
            'hp' => ['required', 'numeric'],
            'slot' => ['required', 'numeric'],
            'image' => ['image', 'max:10240'],
            'special' => ['numeric'],
            'fullscreen' => ['numeric'],
            'background' => ['string'],
            ]);
            
            if(!isset($data['image']) || !$data['image']) {
                $image = "/img/cards/card_bg.png";
            } else {
                $image = null;   
            }

            $classId = $class = Classroom::where('code', '=', $code)->firstOrFail()->id;

            if(!$classId)
                return false;

            $card = Card::create([
                'src' => $image,
                'title' => $data['title'],
                'description' => $data['description'],
                'min_lvl' => $data['minLvl'],
                'type' => $data['type'],
                'type_bg' => $data['bgType'],
                'special' => isset($data['special']) ? $data['special'] : 0 ,
                'width' => $data['width'],
                'margin_top' => $data['marginTop'],
                'margin_left' => $data['marginLeft'],
                'background' => $data['background'],
                'radius' => $data['radius'],
                'xp' => $data['xp'],
                'hp' => $data['hp'],
                'gold' => $data['gold'],
                'slot' => $data['slot'],
                'fullscreen' => isset($data['fullscreen']) ? $data['fullscreen'] : 0,
                'classroom_id' => $classId,
        ]);

        if($image == null)
            // $card->addMedia()
            // ->withManipulations(['thumb' => ['orientation' => '90'])
            //                         ->toMediaCollection('card')
            //                         ->width($data['width'])
            //                         ->singleFile();

             $card->addMedia(request()->image)
             ->toMediaCollection('card');
             

        return redirect('/classroom/'.$code.'/cards');

    }
    
    // Add default cards
    public function importDefault($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        foreach (Card::whereNull('classroom_id')->get() as $card) {

            $newCard = $card->replicate();
            $class->cards()->save($newCard);
        }
        return redirect('/classroom/'.$code.'/cards');
    }

    public function destroy($id) {
        try {
            Card::destroy($id);
        } catch (\Throwable $th) {
            return [ 'error' => $th];
        }
        return 1;
    }
}
