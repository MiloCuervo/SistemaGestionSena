<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class CaseCreatedMail extends Notification implements ShouldQueue
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
        $date = $this->case->created_at->format('d/m/Y H:i');

        $types = [
        'complaint'          => 'Denuncia',
        'request'            => 'Solicitud',
        'right_of_petition'  => 'Derecho de petición',
        'tutelage'           => 'Tutela',
        ];

        $typeText = $types[$this->case->type] ?? $this->case->type;

        $descriptionPreview = $this->case->description 
            ? Str::limit($this->case->description, 100) 
            : 'Sin descripción';

        return (new MailMessage)
            ->subject('Nuevo caso creado!')
            ->greeting('Hola! '. $notifiable->name)
            ->line('El caso: ' . $this->case->case_number)
            ->line('Se ha registrado con éxito en el sistema.')        
            ->line('Fecha de creación: ' . $date)
            ->line('Tipo: ' . $typeText)
            ->line('Descripción: ' . $descriptionPreview)
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
