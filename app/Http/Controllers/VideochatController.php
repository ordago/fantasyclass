<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Notifications\NewUrlMessage;
use App\Videochat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use TaylorNetwork\UsernameGenerator\Generator;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Video;

class VideochatController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('view', $class);
        return $class->videochats;
    }

    public function destroy($id)
    {
        $video = Videochat::find($id);
        $class = Classroom::where('id', $video->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        $video->delete();
    }

    public function toggle()
    {
        $data = request()->validate([
            'id' => ['numeric', 'required'],
            'active' => ['boolean', 'required'],
        ]);
        $video = Videochat::find($data['id']);
        $class = Classroom::where('id', $video->classroom_id)->firstOrFail();
        $this->authorize('update', $class);
        $video->update([
            'active' => $data['active'],
        ]);
    }

    public function notify()
    {
        $data = request()->validate([
            'id' => ['numeric', 'required'],
        ]);
        $video = Videochat::find($data['id']);
        $class = Classroom::where('id', $video->classroom_id)->firstOrFail();
        $this->authorize('view', $class);

        $from['title'] = __('videochat.videochat');
        $from['name'] = $class->adventure_name;
        $from['datetime'] = Carbon::now();
        $from['type'] = "videochat";

        foreach ($class->students as $std) {
            Notification::send($std->classroom->user, new NewUrlMessage(__('videochat.videochat'), __('videochat.new_videochat'), $video->url, __('videochat.open'), $from));
        }
        

    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'name' => ['string', 'required'],
        ]);
        $generator = new Generator();
        $name = $generator->generate($data['name']);

        Videochat::create([
            'name' => $data['name'],
            'active' => false,
            'url' => env('VIDEO_PROVIDER') . env('APP_NAME') . '-' . $class->code . '-' . $name,
            'classroom_id' => $class->id,
        ]);
    }
}
