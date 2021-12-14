<?php

namespace App\Http\Controllers;

use App\Calevent;
use App\Classroom;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $tz = settings()->get('tz', 'Europe/Madrid');

        $data = request()->validate([
            'event' => ['array', 'required'],
        ]);
        $start = Carbon::parse($data['event']['event_start_hour']);
        $end = Carbon::parse($data['event']['event_end_hour']);
        $start->setTimezone($tz);
        $end->setTimezone($tz);
        // $datetime_start = Carbon::createFromFormat('d/m/Y H:i', Carbon::parse($data['event']['date'])->format('d/m/Y') . ' ' . $start->format('H:i'));
        // $datetime_end = Carbon::createFromFormat('d/m/Y H:i', Carbon::parse($data['event']['date'])->format('d/m/Y') . ' ' . $end->format('H:i'));
        
        
        $group = Calevent::max('group') + 1;
        $times = 1;
        if($data['event']['repeat'] == 1 && $data['event']['end_date']) {
            
            $start_date = Carbon::parse($data['event']['date']);
            $end_date = Carbon::parse($data['event']['end_date']);
            $times = $start_date->diffInWeeks($end_date) + 1;
            // return null;
        }
        
        dump($times);
        for($i = 0; $i < $times; $i++) {

            $string_start = Carbon::parse($data['event']['date'])->addWeeks($i)->format('Y-m-d') . " " . $start->format('H:i');
            $string_end = Carbon::parse($data['event']['date'])->addWeeks($i)->format('Y-m-d') . " " . $end->format('H:i');
    
            Calevent::create([
                'info' => json_encode([
                    'start' => $string_start,
                    'end' => $string_end,
                    'title' => $data['event']['title'],
                    'class' => 'sport',
                ]),
                'group' => $group,
                'classroom_id' => $class->id,
                'attendance' => false,
            ]);
        }
        
        
    }
    public function getEvents($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);

        return $class->calevents;

    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $settings = json_encode(["attendance_start" => settings()->get('attendance_start'), "attendance_end" => settings()->get('attendance_end')]);

        return view('attendance.index', compact('class', 'settings'));

    }
}
