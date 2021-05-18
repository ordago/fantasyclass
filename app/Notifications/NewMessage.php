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
    public $url;
    public $type;


    /**
     * Create a new content instance.
     *
     * @return void
     */
    public function __construct($content, $from, $classroom, $user = 'student', $url = null, $type = "message")
    {
        $this->content = $content;
        $this->classroom = $classroom;
        $this->from = $from;
        $this->user = $user;
        $this->url = $url;
        $this->type = $type;
    }

    public function toArray($notifiable)
    {
        $url = $this->url ? $this->url : '/classroom/show/'. $this->classroom;
        if($this->type == 'chat') $this->url = '/inbox';
        return [
            'from' => $this->from,
            'content' => $this->content,
            'url' => $url,
            'type' => $this->type,
            'user' => $this->user,
            'classroom' => $this->classroom,
            'created' => Carbon::now(),
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
        $action = 'open_fantasyclass';
        if($this->type == 'chat')
            $action = "open_chat";

        return (new WebPushMessage)
        ->title('New message')
        ->body($this->from['name'] . ": ".$this->content)
        ->icon('/ic_fc_mono.png')
        ->badge('/one.png')
        ->data($data)
        ->action('FantasyClass', $action);
    }
}
