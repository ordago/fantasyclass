<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class NewInteraction extends Notification
{

    use Queueable;
    public $title;
    public $content;
    public $classroom;
    public $action;
    public $section;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $content, $from, $action, $classroom = null, $section = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->classroom = $classroom;
        $this->action = $action;
        $this->section = $section;
        $this->from = $from;
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'from' => $this->from,
            'content' => $this->content,
            'url' => '/classroom/'. $this->classroom.'/'.$this->section,
            'type' => $this->action,
            'section' => $this->section,
            'classroom' => $this->classroom,
            'user' => 'teacher',
            'created' => Carbon::now(),
        ];
    }
    
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
    }
    
    public function toWebPush($notifiable, $notification)
    {

        $action = "open_fantasyclass_teacher";
        if($this->action == "notify_students") {
            $action = "open_fantasyclass";
        }
        $data = ['id' => $notification->id];
        if($this->classroom) {
            $data['code'] = $this->classroom;
        }
        if($this->section) {
            $data['section'] = $this->section;
        }

        return (new WebPushMessage)
        ->title($this->title)
        ->body($this->from['name'] . ": ".$this->content)
        ->data($data)
        ->action('Open FantasyClass', $action);
    }
    // ->badge('/ic_fc_mono.png')
    // ->icon('/ic_fc_mono.png')
}
