<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class NewUrlMessage extends Notification
{

    use Queueable;
    public $title;
    public $content;
    public $url;
    public $action_title;
    public $from;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $content, $url, $action_title, $from)
    {
        $this->title = $title;
        $this->content = $content;
        $this->url = $url;
        $this->action_title = $action_title;
        $this->from = $from;
    
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'url' => $this->url,
            'action_title' => $this->action_title,
            'from' => $this->from,
            'type' => $this->from['type'],
            'created' => Carbon::now(),
        ];
    }
    
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
    }
    
    public function toWebPush($notifiable, $notification)
    {

        $action = "open_url";
    
        $data = ['id' => $notification->id, 'url' => $this->url];
    
        return (new WebPushMessage)
        ->title($this->title)
        ->icon('/ic_fc_mono.png')
        ->badge('/ic_fc_mono.png')
        ->body($this->content)
        ->data($data)
        ->action($this->action_title, $action);
    }
}
