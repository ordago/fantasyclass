<?php

namespace App;

use App\Notifications\NewMessage;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'email_verified_at',
        'is_student', 'locale', 'refresh_token', 'expires_in', 'token', 'pending_messages'
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class)->using(ClassroomUser::class)->withPivot('role', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function sendMessage($content, $classroom, $type = "message") {
        $from['title'] = __('notifications.message');
        $from['name'] = auth()->user()->name;
        $from['username'] = auth()->user()->username;
        $from['datetime'] = date_format(Carbon::now('Europe/Madrid'), 'd/m/Y H:i');

        Notification::send($this, new NewMessage($content, $from, $classroom, 'student', null, $type));
    }

    public function markPending() {
        $this->update(['pending_messages' => $this->pending_messages + 1]);
    }   
    
    public function removePending() {
        $this->update(['pending_messages' => 0]);
    }

}
