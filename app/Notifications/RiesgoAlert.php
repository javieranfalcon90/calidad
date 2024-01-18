<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Riesgo;
use Illuminate\Support\HtmlString;

class RiesgoAlert extends Notification
{
    use Queueable;

    protected $riesgo;

    /**
     * Create a new notification instance.
     */
    public function __construct(Riesgo $riesgo)
    {
        $this->riesgo = $riesgo;
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

        $url = route('riesgos.show', ['riesgo' => $this->riesgo->id ]);

        if($this->riesgo->estado == 'Nuevo'){
            $text = 'Se ha creado un nuevo Riesgo con código: <b>'.$this->riesgo->codigo. '</b> en el sistema de calidad.';
        }elseif($this->riesgo->estado == 'Evaluado'){
            $text = 'El Riesgo con código: <b>'.$this->riesgo->codigo. '</b> ha pasado a estar Evaluado en el sistema de calidad.';
        }elseif($this->riesgo->estado == 'Cerrado'){
            $text = 'El Riesgo con código: <b>'.$this->riesgo->codigo. '</b> ha pasado a estar Cerrado en el sistema de calidad.';
        }

        return (new MailMessage)
                    ->subject('Alerta de Notificación')
                    ->greeting('Atención!!')
                    ->line(new HtmlString($text))
                    ->action('Ver Riesgo', $url)
                    ->line('Gracias por usar nuestra aplicación.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if($this->riesgo->estado == 'Nuevo'){
            $t = 'Nuevo Riesgo con código: '.$this->riesgo->codigo.'.';
            $type = 'primary';
        }elseif($this->riesgo->estado == 'Evaluado'){
            $t = 'El Riesgo con código: '.$this->riesgo->codigo. ' fue Evaluado.';
            $type = 'info';
        }elseif($this->riesgo->estado == 'Cerrado'){
            $t = 'El Riesgo con código: '.$this->riesgo->codigo. ' fue Cerrada.';
            $type = 'success';
        }

        $url = route('riesgos.show', $this->riesgo->id);

        return [
            'type' => $type,
            'user_id' => auth()->user()->id,
            'username' => auth()->user()->name,
            'text' => $t,
            'url' => $url,
        ];
    }
}
