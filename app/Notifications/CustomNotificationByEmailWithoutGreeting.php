<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CustomNotificationByEmailWithoutGreeting extends Notification
{
    use Queueable;


    public $title;
    public $message;
    public $cc;
    public $buttonText;
    public $url;

    public function __construct($title, $message, $cc = null, $buttonText = null, $url = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->cc = $cc;
        $this->buttonText = $buttonText;
        $this->url = $url;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        if ($this->cc){
            if ($this->url){
                return (new MailMessage)
                    ->subject($this->title)
                    ->greeting('skip default')
                    ->line(new HtmlString($this->message))
                    ->cc($this->cc)
                    ->action($this->buttonText, $this->url);
            }else{
                return (new MailMessage)
                    ->subject($this->title)
                    ->greeting('skip default')
                    ->cc($this->cc)
                    ->line(new HtmlString($this->message));
            }
        }else{
            if ($this->url){
                return (new MailMessage)
                    ->subject($this->title)
                    ->greeting('skip default')
                    ->line(new HtmlString($this->message))
                    ->action($this->buttonText, $this->url);
            }else{
                return (new MailMessage)
                    ->subject($this->title)
                    ->greeting('skip default')
                    ->line(new HtmlString($this->message));
            }
        }
    }
}
