<?php

namespace App\Http\Controllers;

use App\Behaviour;
use App\Classroom;
use App\Student;
use App\Exports\Export;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Firebase\JWT\JWT;


class UtilsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function showMeter($code) {
        return view('utils.meter', compact('code'));
    }
    public function meter($code) {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        foreach ($class->students as $student) {
            if(request()->hp != 0) {
                $student->setProperty('hp', request()->hp);
            }
            if(request()->xp != 0) {
                $student->setProperty('xp', request()->xp);
            }
            if(request()->gold != 0) {
                $student->setProperty('gold', request()->gold);
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
            if($student->classroom->classroom_id != $class->id)
                return abort('403');
            $student->addBehaviour($behaviour->id);
        }
    }
    public function iconPack($category)
    {
        $images = preg_grep('~\.(svg)$~', scandir(public_path() . '/img/icon-packs/'.$category));
        array_walk($images, function(&$value, $key) use ($category) { $value = '/img/icon-packs/' . $category . '/' . $value; } );
        return json_encode($images);
    }

    public function getUserChatInfo()
    {
        $data = request()->validate([
            'username' => ['string', 'required', 'min:3'],
        ]);

        $user = User::where('username', '=', $data['username'])->firstOrFail();
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
          "exp" => $now_seconds+(60*60),  // Maximum expiration time is one hour
          "uid" => auth()->user()->id,
        );
        $token = JWT::encode($payload, $private_key, "RS256");
        return $token;
        
    }

    public function iconPacks()
    {
        $array = array_diff(scandir(public_path() . '/img/icon-packs'), array('..', '.', 'LICENSE'));
        return json_encode($array);
    }

    public function online()
    {
        $expiresAt = Carbon::now()->addMinutes(5);
        Cache::put('user-is-online-' . auth()->user()->id, true, $expiresAt);
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

    public function exportConfidentialDataStudent()
    {
        $headings = [
            Lang::get("students.name"),
            Lang::get("students.password")
        ];

        $students = Student::all()->map(function($item){
            return array('name' => $item->name, 'password_plain' => $item->password_plain);
        });

        return Excel::download(new Export($headings, $students), 'Students.xlsx');
    }
}
