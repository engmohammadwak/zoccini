<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMessageNotification extends Notification
{
    use Queueable;

    private $message;
    private $title;
    private $offer;
    private $order;
    private $type;

    public function __construct($title ,$message ,$order = null , $offer = null, $type = null )
    {
        $this->title = $title;
        $this->message = $message;
        $this->offer = $offer;
        $this->order = $order;
        $this->type = $type;
    }


    public function via($notifiable)
    {
        return ['database'];
    }

    private function data()
    {
        return [
            'title' => $this->title,
            'body' => $this->message,
            'offer' => $this->offer,
            'order' => $this->order,
            'type' => $this->type,
            'icon' => '',
            'action' => '',
        ];
    }

    public function toArray($notifiable)
    {
        return $this->data();
    }

    public function toFCM()
    {
        return $this->data();
    }
}
