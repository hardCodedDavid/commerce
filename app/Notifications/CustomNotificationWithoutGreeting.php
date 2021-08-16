<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CustomNotificationWithoutGreeting extends Notification
{
    use Queueable;

    public $title;
    public $body;
    public $cc;
    public $icon;
    public $description;

    public function __construct($type, $title, $body, $cc, $description)
    {
        $this->title = $title;
        $this->body = $body;
        $this->cc = $cc;
        $this->description = $description;
        switch ($type) {
            case 'deposit':
                $this->icon = '<div class="icon"><i data-feather="corner-right-down"></i></div>';
                break;
            case 'withdrawal':
                $this->icon = '<div class="icon"><i data-feather="corner-down-left"></i></div>';
                break;
            case 'investment':
                $this->icon = '<div class="icon"><i data-feather="layers"></i></div>';
                break;
            case 'trade':
                $this->icon = '<div class="icon"><i data-feather="trending-up"></i></div>';
                break;
            case 'referral':
                $this->icon = '<div class="icon"><i data-feather="users"></i></div>';
                break;
            case 'success':
                $this->icon = '<div class="icon"><i data-feather="check-circle"></i></div>';
                break;
            case 'pending':
                $this->icon = '<div class="icon"><i data-feather="alert-circle"></i></div>';
                break;
            case 'cancelled':
                $this->icon = '<div class="icon"><i data-feather="x-circle"></i></div>';
                break;
            default:
                $this->icon = '<div class="icon"><i data-feather="bell"></i></div>';
                break;
        }
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'icon' => $this->icon,
            'description' => $this->description,
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        if ($this->cc){
            return (new MailMessage)
                ->subject($this->title)
                ->greeting('skip default')
                ->cc($this->cc)
                ->line(new HtmlString($this->body));
        }else{
            return (new MailMessage)
                ->subject($this->title)
                ->greeting('skip default')
                ->line(new HtmlString($this->body));
        }
    }


}
