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
        $settings['disable_your_adventure'] = settings()->get('disable_your_adventure', 0);
        $settings['show_chat'] = settings()->get('show_chat', false);
        $settings['allow_change_class'] = settings()->get('allow_change_class', 1);
        $settings['allow_send_money'] = settings()->get('allow_send_money', 0);
        $settings['transfer_fee'] = settings()->get('transfer_fee', 10);
        $settings['themes'] = array_diff(scandir(public_path() . '/img/icon-packs'), array('..', '.', 'LICENSE'));
        $settings['disabled_themes'] = json_decode(settings()->get('disabled_themes', json_encode([])));
        $settings['custom_images'] = $class->getMedia('avatars');
        $settings['licenses'] = settings()->get('licenses', '');
        
        $teachers = $class->users->where('pivot.role', '>', 0);     
        
        $user = auth()->user()->id;      
        $isAdmin = auth()->user()->classrooms->where('id', $class->id)->where('pivot.role', '=', 2)->first() ? 1 : 0;      
        return view('settings.index', compact('settings', 'class', 'teachers', 'isAdmin', 'user'));
        
    }
    
    public function themes($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $disabled = request()->themes;
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        settings()->set('disabled_themes', json_encode($disabled));
        
    }
    
    public function destroy($code, $id) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $cus = ClassroomUser::where('user_id', '=', auth()->user()->id)->where('classroom_id', '=', $class->id)->firstOrFail();
        
        if($cus->role == 1) {
            $cus->delete();
            return 2;
        } else {
            $this->authorize('admin', $class);
            $cus = ClassroomUser::where('user_id', '=', $id)->where('classroom_id', '=', $class->id)->where('role', '=', 1)->firstOrFail();
            return $cus->delete();
        }

    }

    public function reset($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('admin', $class);
        switch(request()->type) {
            case 'hp':
                $value = 100;        
            break;
            case 'gold':
            case 'xp':
                $value = 0;
            break;
            default:
                abort(403);
            break;
        }
        foreach ($class->students as $student) {
            $student->update([request()->type => $value]);
        }
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
            $old = 0;
            if(request()->prop == 'allow_change_class') {
                $old = 1;
            }
            $value = !settings()->get(request()->prop, $old);
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
