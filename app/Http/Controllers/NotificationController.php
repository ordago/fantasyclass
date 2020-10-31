<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Notifications\NewInteraction;
use App\Notifications\PushDemo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public static function sendToTeachers($user, $classroom, $title, $content, $from, $action, $section = null)
    {
        $class = Classroom::where('code', '=', $classroom)->firstOrFail();
        foreach ($class->users()->where('role', '>', 0)->get() as $teacher) {
            Notification::send($teacher, new NewInteraction(__($title, [], $teacher->locale) . "(" . $from['title'] . ")", $content, $from, $action, $classroom, $section));
        }
    }

    /**
     * Store the PushSubscription.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);

        return response()->json(['success' => true], 200);
    }

    public function destroyAll()
    {
        auth()->user()
            ->unreadNotifications()
            ->get()->each(function ($n) {
                $n->delete();
            });
    }
    public function destroy()
    {

        $data = request()->validate([
            'id' => ['string', 'required'],
        ]);

        $notification = auth()->user()
            ->unreadNotifications()
            ->where('id', $data['id'])
            ->first();

        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }

        return $notification->delete();
    }
}
