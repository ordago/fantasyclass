<?php

namespace App\Http\Controllers;

use App\Card;
use App\CardStudent;
use App\Classroom;
use App\Group;
use App\Http\Classes\Functions;
use App\Mail\NewCardNotification;
use App\Student;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CardsController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $cards = $class->cards->sortBy('type');
        return view('cards.index', compact('class', 'cards'));
    }

    public function create($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        return view('cards.create', compact('class'));
    }

    public function show($code, $id)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $card = Card::where('id', '=', $id)
            ->where('classroom_id', "=", $class->id)
            ->firstOrFail();
        return view('cards.create', compact('class', 'card'));
    }

    public function validateFormat($request)
    {
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
            'special' => ['string'],
            'fullscreen' => ['string'],
            'background' => ['string'],
        ]);
    }

    public function getUserCards()
    {
        $ids = auth()->user()->classrooms()->where('role', '>', 0)->get()->pluck('id');
        return Card::where('own', '=', 1)->whereIn('classroom_id', $ids)->get();
    }

    public function getSharedCards()
    {
        return Card::where('shared', '=', 1)->get();
    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $classId = $class->id;

        $data = $this->validateFormat(request());

        if (!isset($data['image']) || !$data['image']) {
            $image = "/img/cards/card_bg.png";
        } else {
            $image = null;
        }

        if (!$classId)
            return false;

        $card = Card::create([
            'src' => $image,
            'title' => $data['title'],
            'description' => $data['description'],
            'min_lvl' => $data['minLvl'],
            'type' => $data['type'],
            'type_bg' => $data['bgType'],
            'special' => isset($data['special']) ? 1 : 0,
            'width' => $data['width'],
            'margin_top' => $data['marginTop'],
            'margin_left' => $data['marginLeft'],
            'background' => $data['background'],
            'radius' => $data['radius'],
            'xp' => $data['xp'],
            'hp' => $data['hp'],
            'gold' => $data['gold'],
            'slot' => $data['slot'],
            'fullscreen' => isset($data['fullscreen']) ? 1 : 0,
            'classroom_id' => $classId,
            'own' => 1,
        ]);

        if ($image == null) {
            $card->addMedia(request()->file('image'))
                ->toMediaCollection('card');

            $cardPath = $card->getMedia('card')->first();
            $imgPath = $cardPath->collection_name . "/" . $cardPath->uuid . '/' . $cardPath->file_name;
            $path = Storage::disk('public')->path('/') . $imgPath;
            if ($cardPath->mime_type != "image/gif" || $cardPath->size >= 500000) {
                $image = Image::make($path)->resize($data['width'], null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            }
            $card->update(['src' => '/storage/' . $imgPath]);
        }

        return redirect('/classroom/' . $code . '/cards');
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

    public function update($card)
    {

        $card = Card::findOrFail($card);
        $class = Classroom::findOrFail($card->classroom_id);
        $this->authorize('update', $class);

        try {
            $card->update(request()->all());
            $card->update(['own' => 1]);
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

    public function share()
    {
        $data = request()->validate([
            'id' => ['numeric', 'required'],
        ]);
        $card = Card::find($data['id']);
        $cardClass = Classroom::find($card->classroom_id);
        $this->authorize('update', $cardClass);
        $newCard = $card->replicate();
        $newCard->save();
        $card->media->each(function (Media $media) use ($newCard) {
            $props = $media->toArray();
            unset($props['uuid']);
            unset($props['id']);
            dump($media);
            $newCard->addMedia($media->getPath())
                ->preservingOriginal()
                ->withProperties($props)
                ->toMediaCollection($media->collection_name);
        });
        $cardPath = $newCard->getMedia('card')->first();
        $imgPath = $cardPath->collection_name . "/" . $cardPath->uuid . '/' . $cardPath->file_name;
        
        $newCard->update(['src' => '/storage/' . $imgPath, 'classroom_id' => NULL, 'own' => 0, 'shared' => 1]);
        
        Mail::to(env('EMAIL'))->send(new NewCardNotification());

        
    }

    public function import($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $data = request()->validate([
            'id' => ['numeric', 'required'],
        ]);
        $card = Card::find($data['id']);
        $cardClass = Classroom::find($card->classroom_id);
        if($cardClass != null)
            $this->authorize('view', $cardClass);
        $newCard = $card->replicate();
        $class->cards()->save($newCard);
        $newCard->update(['own' => 0, 'shared' => 0]);    
    }

    // Add default cards
    public function importDefault($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        foreach (Card::where('shared', '=', 0)->whereNull('classroom_id')->get() as $card) {

            $newCard = $card->replicate();
            $class->cards()->save($newCard);
        }
        return redirect('/classroom/' . $code . '/cards');
    }

    public function assign($code)
    {
        $data = request()->validate([
            'type' => ['string'],
            'id' => ['numeric'],
            'card' => ['numeric'],
        ]);
        if ($data['type'] == 'student') {
            $student = Student::find($data['id']);
            $classId = $student->classroom->classroom_id;
        } else {
            $group = Group::find($data['id']);
            $classId =  $group->grouping->classroom_id;
        }

        $class = Classroom::where('id', $classId)->where('code', '=', $code)->first();
        $this->authorize('update', $class);

        $card = Card::where('id', $data['card'])->where('classroom_id', $class->id)->first();

        if ($data['type'] == 'student') {
            $student->cards()->attach($card->id);
        } else {
            foreach ($group->students as $student) {
                $student->cards()->attach($card->id);
            }
        }
        return $card;
    }

    public function useDeleteAdmin($id)
    {
        $card = Card::find($id);
        $class = Classroom::find($card->classroom_id);
        $this->authorize('update', $class);

        $data = request()->validate([
            'student' => ['numeric', 'required'],
            'type' => ['numeric'],
        ]);

        $student = Student::find($data['student']);
        if ($student->classroom->classroom_id != $class->id)
            return false;

        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $cardLine = CardStudent::where('card_id', $card->id)
            ->where('student_id', $student->id)
            ->first();

        $cardLine->delete();

        if ($card->special) {
            $gold = 0;
        } else {
            if ($data['type'] == 1) {
                $gold = settings()->get('card_use', 200);
            } else {
                $gold = settings()->get('card_delete', 50);
            }
        }

        if ($card->gold) $student->setProperty('gold', $card->gold, true);
        if ($card->xp) $student->setProperty('xp', $card->xp, true);
        if ($card->hp) $student->setProperty('hp', $card->hp, true);

        if ($gold) {
            $message = __('success_error.use_delete_gold', ['gold' => $gold]);
        } else {
            $message = __('success_error.use_delete');
        }

        return [
            "message" => " " . $message,
            "icon" => "check",
            "type" => "success",
            "gold" => $gold,
        ];
    }

    public function useDelete($id)
    {
        $card = Card::find($id);
        $class = Classroom::find($card->classroom_id);
        $this->authorize('update', $class);

        $data = request()->validate([
            'student' => ['numeric', 'required'],
            'action' => ['boolean'],
            'type' => ['numeric'],
        ]);

        $student = Student::find($data['student']);
        if ($student->classroom->classroom_id != $class->id)
            return false;


        $cardLine = CardStudent::where('card_id', $card->id)
            ->where('student_id', $student->id)
            ->where('marked', $data['type'])
            ->first();


        if ($data['action']) {
            settings()->setExtraColumns(['classroom_id' => $class->id]);
            if ($data['type'] == 1) {
                if ($student->level && $card->min_lvl > $student->level->number) {
                    return [
                        "message" => " " . __('success_error.shop_failed_level'),
                        "icon" => "times",
                        "type" => "error",
                    ];
                }
                $cost = settings()->get('card_use', 200);
                if ($card->gold == 0 && $student->gold < $cost) {
                    return [
                        "message" => " " . __('success_error.shop_failed_money'),
                        "icon" => "times",
                        "type" => "error",
                    ];
                }
                if ($card->gold) {
                    $student->setProperty('gold', $card->gold, true);
                } else if (!$card->special) {
                    $student->setProperty('gold', $cost * -1, true);
                }
                if ($card->xp) $student->setProperty('xp', $card->xp, true);
                if ($card->hp) $student->setProperty('hp', $card->hp, true);
            } else {
                $cost = settings()->get('card_delete', 50);
                if ($student->gold < $cost) {
                    return [
                        "message" => " " . __('success_error.shop_failed_money'),
                        "icon" => "times",
                        "type" => "error",
                    ];
                }
                $student->setProperty('gold', $cost * -1, true);
            }
            $cardLine->delete();
            return [
                "message" => " " . __('success_error.update_success'),
                "icon" => "check",
                "type" => "success",
            ];
        } else {
            $cardLine->update(['marked' => 0]);
        }
    }

    public function random($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        return CardsController::getRandomCard($code);
    }

    public static function getRandomCard($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        if (!$class->cards->count())
            return false;

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $probabilites = json_decode(settings()->get('card_probabilities', json_encode([55, 30, 10, 5])));

        do {
            $typeValue = Functions::getRandomWeightedElement(array(1 => $probabilites[0], 2 => $probabilites[1], 3 => $probabilites[2], 4 => $probabilites[3]));
            $card = Card::where('type', $typeValue)->where('classroom_id', $class->id)->inRandomOrder()->first();
        } while ($card == null);
        return $card;
    }

    public function destroy($id)
    {
        $card = Card::findOrFail($id);
        $class = Classroom::findOrFail($card->classroom_id);
        $this->authorize('update', $class);
        try {
            $card->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }
}
