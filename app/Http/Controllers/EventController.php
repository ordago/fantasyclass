<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Event;
use Arcanedev\LaravelSettings\Utilities\Arr;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $this->authorize('view', $class);

        $events = Event::where('type', "!=", 13)->whereNull('classroom_id')->orWhere('classroom_id', '=', $class->id)->get();
        $disabled = settings()->get('disabled_events', json_encode([]));
        
        return view('events.index',  compact('class', 'events', 'disabled'));
    }
    
    public function update()
    {
        $data = request()->validate([
            'event.id' => ['numeric', 'required'],
            'event.title' => ['string', 'required'],
            'event.content' => ['string', 'required'],
            'event.type' => ['numeric', 'required'],
            'event.classroom_id' => ['numeric', 'required'],
        ]);
    
        $event = Event::findOrFail($data['event']['id']);
        $class = Classroom::findOrFail($event->classroom_id);
        $this->authorize('update', $class);
    
        return $event->update($data['event']);
    }

    public function add()
    {
        $data = request()->validate([
            'event.title' => ['string', 'required'],
            'event.content' => ['string', 'required'],
            'event.type' => ['numeric', 'required'],
            'event.classroom_id' => ['numeric', 'required'],
        ]);

        $class = Classroom::findOrFail($data['event']['classroom_id']);
        $this->authorize('update', $class);

        return Event::create($data['event']);
    }

    public function disable($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);

        $data = request()->validate([
            'id' => ['numeric', 'required']
        ]);

        $disabled = json_decode(settings()->get('disabled_events', json_encode([])));

        $exists = array_search($data['id'], $disabled); 

        if($exists !== false) {
            array_splice($disabled, $exists, 1);
        } else {
            array_push($disabled, $data['id']);
        }

        settings()->set('disabled_events', json_encode($disabled));

    }

    public function destroy($id)
    {
        $event = Event::where('id', '=', $id)->first();
        $class = Classroom::where('id', $event->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        try {
            $event->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }
    
    public function show($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        $max = 0;
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $disabled = json_decode(settings()->get('disabled_events', "[]"));

        do {
            $again = false;
            $event = Event::whereNotIn('id', $disabled)
                            ->where(function($query) use ($class){
                                $query->whereNull('classroom_id');
                                $query->orWhere('classroom_id', '=', $class->id);
                            })
                            ->inRandomOrder()
                            ->first();
            if (($event->type == 1 || $event->type == 3 || $event->type == 2 || $event->type == 4 || $event->type == 8 || $event->type == 9 || $event->type == 10 || $event->type == 11 || $event->type == 12 || $event->type == 13) && !count($class->students)) {
                $again = true;
            } else if ($event->type == 5 && (!$class->students || !count($class->grouping->first()->groups))) {
                $again = true;
            } else if ($event->type == 6 && !count($class->students->where('hp', 0))) {
                $again = true;
            } else if ($event->type == 7 && $class->character_theme == 0) {
                $again = true;
            } else if ($event->type == 13) {
                // TODO For now event 13 is disabled
                $again = true;
            }
            $max++;
        } while ($again && $max < 1000);

        $return = null;
        if($max == 1000)
            return redirect('/classroom/'.$class->code.'/');
        switch ($event->type) {
            case 0:
                $return = [
                    'event' => $event,
                ];
            break;
            case 14:
                $return = [
                    'students' => $class->students,
                    'event' => $event,
                ];
            break;
            case 1:
                $options = json_decode($event->options);
                $return = [
                    'hp' => rand($options->hpMin, $options->hpMax) * -1,
                    'student' => StudentController::getRandomStudent($class),
                    'event' => $event,
                ];
                break;
            case 2:
                $options = json_decode($event->options);
                $return = [
                    'hp' => rand($options->hpMin, $options->hpMax) * -1,
                    'event' => $event,
                ];
                break;
            case 3:
                $return = [
                    'student' => StudentController::getRandomStudent($class),
                    'event' => $event,
                ];
                break;
            case 4:
                $options = json_decode($event->options);
                $return = [
                    'hp' => rand($options->hpMin, $options->hpMax),
                    'student' => $class->students->where('hp', '>', 0)->sortBy('hp')->first(),
                    'event' => $event,
                ];
                break;
            case 5:
                $options = json_decode($event->options);
                $student = StudentController::getRandomStudent($class);
                $return = [
                    'hp' => rand($options->hpMin, $options->hpMax) * -1,
                    'student' => $student,
                    'groupMembers' => $student->groups->first()->students->where('id', '!=', $student->id),
                    'event' => $event,
                ];
                break;
            case 6:
                $return = [
                    'hp' => 1,
                    'student' => $class->students()->where('hp', '=', 0)->inRandomOrder()->first(),
                    'event' => $event,
                ];
                break;
            case 7:
                $return = [
                    'class' => '/img/character/characters/' . $class->characterTheme->characters->random(1)->first()->id . ".png",
                    'event' => $event,
                ];
                break;
            case 8:
                $options = json_decode($event->options);
                $return = [
                    'hp' => rand($options->hpMin, $options->hpMax)  * -1,
                    'gold' => rand($options->goldMin, $options->goldMax),
                    'student' => StudentController::getRandomStudent($class),
                    'event' => $event,
                ];
                break;
            case 9:
                $options = json_decode($event->options);
                $return = [
                    'xp' => rand($options->xpMin, $options->xpMax),
                    'student' => StudentController::getRandomStudent($class),
                    'event' => $event,
                ];
                break;
            case 10:
                $options = json_decode($event->options);
                $return = [
                    'gold' => rand($options->goldMin, $options->goldMax) * $options->mult,
                    'student' => StudentController::getRandomStudent($class),
                    'event' => $event,
                ];
                break;
            case 11:
                $options = json_decode($event->options);
                $return = [
                    'card' => CardsController::getRandomCard($class->code),
                    'student' => StudentController::getRandomStudent($class),
                    'event' => $event,
                ];
                break;
            case 12:
                $options = json_decode($event->options);
                $action = rand(0, 1);
                if ($action) {
                    $value = rand($options->goldMin, $options->goldMax);
                    $text = $options->textOK;
                } else {
                    $value = rand($options->hpMin, $options->hpMax) * -1;
                    $text = $options->textKO;
                }

                $return = [
                    'action' => $action,
                    'event' => $event,
                    'text' => $text,
                    'value' => $value,
                ];
                break;
        }

        return view('events.show', compact('class', 'return'));
    }
}
