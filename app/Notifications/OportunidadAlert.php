<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Oportunidad;
use Illuminate\Support\HtmlString;

class OportunidadAlert extends Notification
{
    use Queueable;

    protected $oportunidad;

    /**
     * Create a new notification instance.
     */
    public function __construct(Oportunidad $oportunidad)
    {
        $this->oportunidad = $oportunidad;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $url = route('oportunidades.show', ['oportunidad' => $this->oportunidad->id ]);

        if($this->oportunidad->estado == 'Nuevo'){
            $text = 'Se ha creado una nueva Oportunidad con código: <b>'.$this->oportunidad->codigo. '</b> en el sistema de calidad.';
        }elseif($this->oportunidad->estado == 'Cerrado'){
            $text = 'La Oportunidad con código: <b>'.$this->oportunidad->codigo. '</b> ha pasado a estar Cerrada en el sistema de calidad.';
        }

        return (new MailMessage)
                    ->subject('Alerta de Notificación')
                    ->greeting('Atención!!')
                    ->line(new HtmlString($text))
                    ->action('Ver Oportunidad', $url)
                    ->line('Gracias por usar nuestra aplicación.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if($this->oportunidad->estado == 'Nuevo'){
            $t = 'Nueva Oportunidad con código: '.$this->oportunidad->codigo.'.';
            $type = 'primary';
        }elseif($this->oportunidad->estado == 'Cerrado'){
            $t = 'La Oportunidad con código: '.$this->oportunidad->codigo. ' fue Cerrada.';
            $type = 'success';
        }

        $url = route('oportunidades.show', $this->oportunidad->id);

        return [
            'type' => $type,
            'user_id' => auth()->user()->id,
            'username' => auth()->user()->name,
            'text' => $t,
            'url' => $url,
        ];
    }
}
