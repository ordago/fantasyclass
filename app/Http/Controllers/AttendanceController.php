<?php

namespace App\Http\Controllers;

use App\Calevent;
use App\Classroom;
use App\Student;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        }

        $subject = Subject::where('classroom_id', $class->id)->where('id', $data['event']['subject'])->firstOrFail();
        for($i = 0; $i < $times; $i++) {

            $string_start = Carbon::parse($data['event']['date'])->setTimezone($tz)->addWeeks($i)->format('Y-m-d') . " " . $start->format('H:i');
            $string_end = Carbon::parse($data['event']['date'])->setTimezone($tz)->addWeeks($i)->format('Y-m-d') . " " . $end->format('H:i');
    
            Calevent::create([
                'info' => json_encode([
                    'start' => $string_start,
                    'end' => $string_end,
                    'title' => $data['event']['title'],
                    'class' => $subject->class,
                ]),
                'task' => $data['event']['task'],
                'group' => $group,
                'subject_id' => $subject->id,
                'classroom_id' => $class->id,
                'attendance' => false,
            ]);
        }
        
        
    }
    public function destroy($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'event' => ['numeric', 'required'],
            'all' => ['boolean', 'required'],
        ]);
        
        $calevent = Calevent::where('id', $data['event'])->where('classroom_id', $class->id)->firstOrFail();
        if($data['all']) {
            DB::table('calevent_student')->whereIn('calevent_id', DB::table('calevents')->where('group', $calevent->group)->get()->pluck('id'))->delete();
            DB::table('calevents')->where('group', $calevent->group)->delete();
        } else {
            DB::table('calevent_student')->where('calevent_id', $calevent->id)->delete();
            $calevent->delete();
        }
        
    }

    public function info($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'event' => ['numeric', 'required'],
        ]);

        $students = $class->students()->with(['calevents' => function ($query) use ($data) {
            $query
                ->where('calevent_id', '=', $data['event']);
        }])->get();

        $students->each(function ($student) {
            if (!count($student->calevents)) {
                $student->calevents->push(['pivot' => ['type' => null, 'student_id' => $student->id]]);
            }
        });

        return ['students' => $students];
    }
    public function disable($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'event' => ['numeric', 'required'],
        ]);

        $calevent = Calevent::where('classroom_id', $class->id)->where('id', $data['event'])->firstOrFail();
        $calevent->update([
            'attendance' => false,
        ]);

        return true;

    }
    public function storeAttendance($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'students' => ['array', 'required'],
            'event' => ['numeric', 'required'],
        ]);

        $calevent = Calevent::where('classroom_id', $class->id)->where('id', $data['event'])->firstOrFail();
        foreach ($data['students'] as $student) {
            $studentObj = Student::findOrFail($student['id']);
            $studentObj->calevents()->sync([$calevent->id => ['type' => $student['calevents'][0]['pivot']['type']]], false);
        }
        $calevent->update([
            'attendance' => true,
        ]);

        return true;

    }
    public function getEvents($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);

        return ['events' => $class->calevents, 'subjects' => $class->subjects];

    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $settings = json_encode(["hideWeekends" => settings()->get('hideWeekends', true), "attendance_start" => settings()->get('attendance_start'), "attendance_end" => settings()->get('attendance_end')]);

        return view('attendance.index', compact('class', 'settings'));

    }
}
