<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class EmetteurRepareNotification extends Notification
{
    protected $emetteur;

    public function __construct($emetteur)
    {
        $this->emetteur = $emetteur;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'L’émetteur ' . $this->emetteur->type . ' #' . $this->emetteur->reference . ' a été réparé.',
            'emetteur_id' => $this->emetteur->id,
        ];
    }
}

