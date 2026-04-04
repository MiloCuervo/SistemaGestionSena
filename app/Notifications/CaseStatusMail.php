<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CaseStatusMail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $case)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statuses = [
            'attended'     => 'Atendido',
            'in_progress'  => 'En progreso',
            'not_attended' => 'No atendido',
        ];
        $statusText = $statuses[$this->case->status] ?? $this->case->status;

        return (new MailMessage)
            ->subject('El caso número: ' . $this->case->case_number. ', se ha actualizado con éxito!')
            ->greeting('Hola! ' . $notifiable->name)
            ->line('El estado del caso: ' . $this->case->case_number . '. Ha sido actualizado.')
            ->line('Estado actual: ' . $statusText)
            ->line('Para más información te invitamos a iniciar sesión en el sistema de gestión.')
            ->action('Ir a SGS', route('user.cases.show', $this->case->id))
            ->salutation("Atentamente,  \nSENA | Sistema de Gestión.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
