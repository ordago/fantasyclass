<?php

namespace App\Http\Controllers;

use App\Card;
use App\Classroom;
use App\Http\Classes\Functions;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $cards = $class->cards->sortBy('type');
        $this->getRandomCard($code);
        return view('cards.index', compact('class', 'cards'));
    }

    public function create($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        return view('cards.create', compact('class'));
    }

    public function show($code, $id) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $card = Card::where('id', '=', $id)
                    ->where('classroom_id', "=", $class->id)
                    ->firstOrFail();
        return view('cards.create', compact('class', 'card'));
    }

    public function validateFormat($request) {
        return $request->validate([
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
    }

    public function store($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $classId = $class->id;
        $data = $this->validateFormat(request());
            
            if(!isset($data['image']) || !$data['image']) {
                $image = "/img/cards/card_bg.png";
            } else {
                $image = null;   
            }
            
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
                
                if($image == null) {
                    $card->addMedia(request()->file('image'))
                    ->toMediaCollection('card');
                    
                    $cardPath = $card->getMedia('card')->first();
                    $imgPath = $cardPath->collection_name . "/" . $cardPath->id . '/' . $cardPath->file_name;
                    $path = Storage::disk('public')->path('/').$imgPath;        
                    if($cardPath->mime_type != "image/gif" || $cardPath->size >= 500000) {
                        $image = Image::make($path)->resize($data['width'], null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save();
                        
                    }
                    $card->update(['src' => '/storage/'.$imgPath]);  
                }
                
                return redirect('/classroom/'.$code.'/cards');
        
            }
            
            public function rules()
            {
                return [
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
            ];
        }

        public function update($card) {
            
            $card = Card::findOrFail($card);
            $class = Classroom::findOrFail($card->classroom_id);
            $this->authorize('update', $class);
            
            try {
                $card->update(request()->all());
                return [
                    "message" => __('success_error.update_success'),
                    "type" => "success",
                    "icon" => "check"
                ];
                
        } catch (\Throwable $th) {
            return [
                    "message" => __('success_error.error'),
                    "type" => "times",
                    "type" => "error"
            ];
            return $th;
        }
        
    }
    
    // Add default cards
    public function importDefault($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        foreach (Card::whereNull('classroom_id')->get() as $card) {
            
            $newCard = $card->replicate();
            $class->cards()->save($newCard);
        }
        return redirect('/classroom/'.$code.'/cards');
    }
    
    public function getRandomCard($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        
        settings()->setExtraColumns(['user_id' => $class->id]);
        $probabilites[0] = settings()->get('cards_common', 55);
        $probabilites[1] = settings()->get('cards_rare', 30);
        $probabilites[2] = settings()->get('cards_epic', 10);
        $probabilites[3] = settings()->get('cards_legendary', 5);

        do {
            $typeValue = Functions::getRandomWeightedElement(array(1=>$probabilites[0], 2=>$probabilites[1], 3=>$probabilites[2], 4=>$probabilites[3]));
            $card = Card::where('type', $typeValue)->inRandomOrder()->first();
        } while($card == null);
        
        return $card;
    }
    
    public function destroy ($id) {
        $card = Card::findOrFail($id);
        $class = Classroom::findOrFail($card->classroom_id);
        $this->authorize('update', $class);
        try {
            $card->delete();
        } catch (\Throwable $th) {
            return [ 'error' => $th];
        }
        return 1;
    }
}
