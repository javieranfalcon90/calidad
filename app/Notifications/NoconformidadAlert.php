<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Noconformidad;
use Illuminate\Support\HtmlString;

class NoconformidadAlert extends Notification
{
    use Queueable;

    protected $noconformidad;

    /**
     * Create a new notification instance.
     */
    public function __construct(Noconformidad $noconformidad)
    {
        $this->noconformidad = $noconformidad;
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

        $url = route('noconformidades.show', ['noconformidad' => $this->noconformidad->id ]);

        if($this->noconformidad->estado == 'Nuevo'){
            $text = 'Se ha creado una nueva No Conformidad con código: <b>'.$this->noconformidad->codigo. '</b> en el sistema de calidad.';
        }elseif($this->noconformidad->estado == 'Cerrado'){
            $text = 'La No Conformidad con código: <b>'.$this->noconformidad->codigo. '</b> ha pasado a estar Cerrada en el sistema de calidad.';
        }

        return (new MailMessage)
                    ->subject('Alerta de Notificación')
                    ->greeting('Atención!!')
                    ->line(new HtmlString($text))
                    ->action('Ver No Conformidad', $url)
                    ->line('Gracias por usar nuestra aplicación.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if($this->noconformidad->estado == 'Nuevo'){
            $t = 'Nueva No Conformidad con código: '.$this->noconformidad->codigo.'.';
            $type = 'primary';
        }elseif($this->noconformidad->estado == 'Cerrado'){
            $t = 'La No Conformidad con código: '.$this->noconformidad->codigo. ' fue Cerrada.';
            $type = 'success';
        }

        $url = route('noconformidades.show', $this->noconformidad->id);

        return [
            'type' => $type,
            'user_id' => auth()->user()->id,
            'username' => auth()->user()->name,
            'text' => $t,
            'url' => $url,
        ];
    }
}
