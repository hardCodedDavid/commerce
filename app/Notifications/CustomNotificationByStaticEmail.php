<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CustomNotificationByStaticEmail extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $buttonText;
    public $url;
    public $cc;

    public function __construct($title, $message, $buttonText = null, $url = null, $cc = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->buttonText = $buttonText;
        $this->url = $url;
        $this->cc = $cc;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        switch (true){
            case is_null($this->cc):
                if ($this->url){
                    return (new MailMessage)
                        ->subject($this->title)
                        ->greeting('skip default')
                        ->line('Hello,')
                        ->line(new HtmlString($this->message))
                        ->action($this->buttonText, $this->url);
                }else{
                    return (new MailMessage)
                        ->subject($this->title)
                        ->greeting('skip default')
                        ->line('Hello,')
                        ->line(new HtmlString($this->message));
                }
            default:
                if ($this->url){
                    return (new MailMessage)
                        ->subject($this->title)
                        ->cc($this->cc)
                        ->greeting('skip default')
                        ->line('Hello,')
                        ->line(new HtmlString($this->message))
                        ->action($this->buttonText, $this->url);
                }else{
                    return (new MailMessage)
                        ->subject($this->title)
                        ->cc($this->cc)
                        ->greeting('skip default')
                        ->line('Hello,')
                        ->line(new HtmlString($this->message));
                }
        }
    }
}
