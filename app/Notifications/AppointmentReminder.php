<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification
{
    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable) : MailMessage
    {
        return (new MailMessage)
            ->subject('Recordatorio de cita')
            ->line('Tienes una cita en 1 hora.')
            ->line('Hora: ' . $this->appointment->date_time)
            ->line('Gracias por confiar en nosotros.');
    }
}
