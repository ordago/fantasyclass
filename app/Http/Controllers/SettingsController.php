<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\ClassroomUser;
use App\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $settings['probabilities'] = json_decode(settings()->get('card_probabilities', json_encode([55, 30, 10, 5])));
        $settings['card_use'] = settings()->get('card_use', 200);
        $settings['card_delete'] = settings()->get('card_delete', 50);
        $settings['night'] = settings()->get('night', false);
        $settings['rain'] = settings()->get('rain', false);
        $settings['snow'] = settings()->get('snow', false);
        $settings['fog'] = settings()->get('fog', false);
        $settings['num_cards'] = settings()->get('num_cards', 5);
        $settings['allow_upload'] = settings()->get('allow_upload', false);

        $teachers = $class->users->where('pivot.role', '>', 0);     
        
        $user = auth()->user()->id;      
        $isAdmin = auth()->user()->classrooms->where('id', $class->id)->where('pivot.role', '=', 2)->first() ? 1 : 0;      
        return view('settings.index', compact('settings', 'class', 'teachers', 'isAdmin', 'user'));

    }

    public function destroy($code, $id) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);
        $cus = ClassroomUser::where('user_id', '=', $id)->where('classroom_id', '=', $class->id)->where('role', '=', 1)->firstOrFail();
        return $cus->delete();
    }

    public function invite($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);
        $teacher = User::where('email', '=', request()->email)->first();
        if(!$teacher) {
            return [
                "message" => __('success_error.email_not_recognised'),
                "type" => "error",
                "icon" => "times",
            ];
        }

        try {
            ClassroomUser::create([
                'user_id' => $teacher->id,
                'classroom_id' => $class->id,
                'role' => 1,
            ]);
        } catch (\Throwable $th) {
            return [
                "message" => __('success_error.user_already_invited'),
                "type" => "error",
                "icon" => "times",
            ];
        }
        return [
            "message" => __('success_error.insert_success'),
            "type" => "success",
            "icon" => "check",
            "teacher" => $teacher,
        ];
    }
    public function updateSetting($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        if (request()->action == 'toggle') {
            $value = !settings()->get(request()->prop, 0);
            settings()->set(request()->prop, $value);
        } else if(request()->action == 'update') {
            if(request()->prop == "card_probabilities") {
                
                $values[0] = request()->value[1];
                $values[1] = request()->value[2] - request()->value[1];
                $values[2] = request()->value[3] - request()->value[2];
                $values[3] = request()->value[4] - request()->value[3];
                $value = settings()->set(request()->prop, json_encode($values));
            } else {
                $value = settings()->set(request()->prop, request()->value);
            }
        }
        settings()->save();
        return $value ? true : false;
    }

}
