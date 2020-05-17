<?php

namespace App\Http\Controllers;

use App\Card;
use App\Classroom;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $cards = $class->cards->sortBy('type');
        return view('cards.index', compact('class', 'cards'));
    }

    public function create($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        return view('cards.create', compact('class'));
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
