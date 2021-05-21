<?php

namespace App\Http\Controllers;

use App\Behaviour;
use App\Challenge;
use App\Classroom;
use App\Student;
use App\Exports\Export;
use App\Http\Classes\Functions;
use App\Mail\ReportUser;
use App\Notifications\NewMessage;
use App\Rating;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class UtilsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function showMeter($code)
    {
        return view('utils.meter', compact('code'));
    }
    public function meter($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        foreach ($class->students as $student) {
            if (request()->hp != 0) {
                $student->setProperty('hp', request()->hp, true, 'volume');
            }
            if (request()->xp != 0) {
                $student->setProperty('xp', request()->xp, 'volume');
            }
            if (request()->gold != 0) {
                $student->setProperty('gold', request()->gold, 'volume');
            }
        }
    }
    public function massive($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        $data = request()->validate([
            'behaviour' => ['numeric', 'required'],
            'students' => ['array', 'required'],
        ]);
        $behaviour = Behaviour::where('id', $data['behaviour'])->where('classroom_id', $class->id)->first();
        foreach ($data['students'] as $id) {
            $student = Student::find($id);
            if ($student->classroom->classroom_id != $class->id)
                return abort('403');
            $student->addBehaviour($behaviour->id);
        }
    }
    public function iconPack($category)
    {
        $images = preg_grep('~\.(svg)$~', scandir(public_path() . '/img/icon-packs/' . $category));
        array_walk($images, function (&$value, $key) use ($category) {
            $value = '/img/icon-packs/' . $category . '/' . $value;
        });
        return json_encode($images);
    }

    public function getShop()
    {
        $images = preg_grep('~\.(png)$~', scandir(public_path() . '/img/shop/craft/'));
        array_walk($images, function (&$value, $key) {
            $value = '/img/shop/craft/' . $value;
        });
        return json_encode($images);
    }

    public function impostorClear($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        settings()->setExtraColumns(['classroom_id' => $class->id]);
        settings()->forget('impostor');
    }

    public function impostor($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'id' => ['numeric', 'required'],
        ]);
        $student = Student::find($data['id']);
        if ($student->classroom->classroom_id != $class->id)
            abort(403);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        settings()->set('impostor', $student->id);
    }

    public function showChat()
    {
        if (Carbon::parse(auth()->user()->banned)->gt(Carbon::now())) {
            abort(403, "You're banned until " . Carbon::parse(auth()->user()->banned)->toDateTimeString());
        }
        auth()->user()->removePending();
        return view('utils.chat');
    }
    public function notifyChat()
    {
        $from['title'] = __('notifications.message');
        $from['name'] = auth()->user()->name;
        $from['username'] = auth()->user()->username;
        $from['datetime'] = Carbon::now();
        foreach (request()->users as $user) {
            if ($user != auth()->user()->id) {
                $userobj = User::find($user);
                Notification::send($userobj, new NewMessage(request()->message, $from, null, 'student', '/inbox', 'chat'));
                $userobj->markPending();
            }
        }
    }

    public function getUserChatInfo()
    {
        $data = request()->validate([
            'username' => ['string', 'required', 'min:3'],
        ]);

        $user = User::where('username', '=', $data['username'])->firstOrFail();
        if ($user->id == auth()->user()->id)
            abort(403);

        return ['id' => $user->id, 'username' => $user->username];
    }

    public function getFirebaseToken()
    {
        $service_account_email = env('FIREBASE_ACCOUNT_EMAIL');
        $private_key = env('FIREBASE_SECRET');

        $now_seconds = time();
        $payload = array(
            "iss" => $service_account_email,
            "sub" => $service_account_email,
            "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
            "iat" => $now_seconds,
            "exp" => $now_seconds + (60 * 60),  // Maximum expiration time is one hour
            "uid" => auth()->user()->id,
        );
        $token = JWT::encode($payload, $private_key, "RS256");
        return $token;
    }

    public function iconPacks($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $array = array_diff(scandir(public_path() . '/img/icon-packs'), array('..', '.', 'LICENSE'));

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $disabled = json_decode(settings()->get('disabled_themes', json_encode([])));
        foreach ($disabled as $theme) {
            $index = array_search($theme, $array);
            if ($index !== false) {
                unset($array[$index]);
            }
        }
        $result[0] = $class->getMedia('avatars');
        $result[1] = $array;
        $result[2] = settings()->get('licenses', '');

        return $result;
    }
    public function getThemes()
    {
        $array = array_diff(scandir(public_path() . '/img/bg/'), array('..', '.', 'old', 'base'));

        foreach ($array as $theme) {
            $images[$theme]['images'] = preg_grep('~\.(png)$~', scandir(public_path() . '/img/bg/' . $theme));
            $images[$theme]['name'] = $theme;
        }
        return json_encode($images);
    }

    public function online()
    {
        $expiresAt = Carbon::now()->addMinutes(5);
        Cache::put('user-is-online-' . auth()->user()->id, true, $expiresAt);
    }

    function getObjects($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        if (isset(request()->limit) && request()->limit) {
            return $class->items()->where('for_sale', 1)->where(function ($query) {
                $query->whereNull('craft')
                    ->orWhere('craft', 'LIKE', '\[\]');
            })->get();
        } else {
            return $class->items()->where(function ($query) {
                $query->whereNull('craft')
                    ->orWhere('craft', 'LIKE', '\[\]');
            })->get();
        }
    }

    public function externalLink($type, $code)
    {

        $text = explode(":", Functions::simple_crypt($code, "d"));
        $id = $text[1];


        switch ($type) {
            case 'challenges':
                $object = Challenge::where('id', $id)->with('attachments', 'comments')->first()->append('questioninfo');
                if ($object->completion != 4)
                    abort(403, "Action not allowed :(");
                $class = Classroom::where('id', '=', $object->classroom())->where('code', '=', $text[0])->firstOrFail();
                $student = Functions::getCurrentStudent($class, []);
                $challengeStudent = $student->challenges->where('id', $object->id)->first();
                if (!$challengeStudent) {
                    $object->get = true;
                    $student->challenges()->attach($object->id);
                    $cards = [];
                    if ($object->auto_assign == 1) {
                        for ($i = 0; $i < $object->cards; $i++) {
                            array_push($cards, CardsController::getRandomCard($class->code));
                        }
                    }
                    $student->assignChallenge($object, 1, $cards);
                } else $object->get = false;
                if (Rating::where('student_id', $student->id)->where('challenge_id', $object->id)->get()->count()) {
                    $object->rated = 1;
                } $object->rated = 1;
                $object->completed = true;
                break;

            default:
                $object = null;
                break;
        }

        $object->etype = $type;
        $code = $class->code;
        return view('utils.external', compact('class', 'student', 'object', 'code'));
    }

    public function music()
    {
        $directory = "/music/";
        $music = [];

        $sounds = Storage::disk('music')->files();

        foreach ($sounds as $sound) {
            $soundName = explode('.', $sound)[0];
            $music[$soundName] = $sound;
        }
        return view('utils.music', compact('music'));
    }

    public function send2admin()
    {
        Mail::to(env('EMAIL'))->send(new ReportUser(request()->messages, request()->room));
    }

    public function exportConfidentialDataStudent($code)
    {

        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $headings = [
            __("students.name"),
            __("auth.username"),
            __("students.password")
        ];

        $students = $class->students->whereNotNull('password_plain')->map(function ($item) {
            return array('name' => $item->name, 'username' => $item->username, 'password_plain' => $item->password_plain);
        });

        return Excel::download(new Export($headings, $students), 'Students.xlsx');
    }
}
