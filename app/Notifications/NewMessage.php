<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class NewMessage extends Notification
{

    use Queueable;
    public $content;
    public $classroom;
    public $from;
    public $data;


    /**
     * Create a new content instance.
     *
     * @return void
     */
    public function __construct($content, $from, $classroom, $user = 'student')
    {
        $this->content = $content;
        $this->classroom = $classroom;
        $this->from = $from;
        $this->user = $user;
    }

    public function toArray($notifiable)
    {
        return [
            'from' => $this->from,
            'content' => $this->content,
            'url' => '/classroom/show/'. $this->classroom,
            'type' => 'message',
            'user' => $this->user,
            'classroom' => $this->classroom,
            'created' => Carbon::now('Europe/Madrid')->toIso8601String()
        ];
    }
    
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
    }
    
    public function toWebPush($notifiable, $notification)
    {
        $data = ['id' => $notification->id];
        if($this->classroom) {
            $data['code'] = $this->classroom;
        }

        return (new WebPushMessage)
        ->title('New message')
        ->icon('/ic_fc_mono.png')
        ->body($this->from['name'] . ": ".$this->content)
        ->data($data)
        ->action('FantasyClass', 'open_fantasyclass');
    }
}
