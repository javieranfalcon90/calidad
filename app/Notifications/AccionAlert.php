<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Accion;
use Illuminate\Support\HtmlString;

class AccionAlert extends Notification
{
    use Queueable;

    protected $accion;

    /**
     * Create a new notification instance.
     */
    public function __construct(Accion $accion)
    {
        $this->accion = $accion;
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

        $url = route('acciones.show', ['accion' => $this->accion->id ]);
            
        if($this->accion->accionable_type == 'App\Models\Oportunidad'){
            $how = 'la Oportunidad con código: <b>'.$this->accion->accionable->codigo.'</b>';
        }elseif($this->accion->accionable->analisisable_type == 'App\Models\Riesgo'){
            $how = 'el Riesgo con código: <b>'.$this->accion->accionable->analisisable->codigo.'</b> ';
        }else{
            $how = 'la No Conformidad con código: <b>'.$this->accion->accionable->analisisable->codigo.'</b> ';
        }

        if($this->accion->estado == 'Nuevo'){
            $text = 'Se ha creado una nueva Acción para '. $how .' en el sistema de calidad.';
        }elseif($this->accion->estado == 'En Seguimiento'){
            $text = 'La Acción de '. $how .' ha pasado a estar En Seguimiento en el sistema de calidad.';
        }elseif($this->accion->estado == 'Cerrado'){
            $text = 'La Acción de '. $how .' ha pasado a estar Cerrada en el sistema de calidad.';
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

        if($this->accion->accionable_type == 'App\Models\Oportunidad'){
            $how = 'Oportunidad con código: '.$this->accion->accionable->codigo;
        }elseif($this->accion->accionable->analisisable_type == 'App\Models\Riesgo'){
            $how = 'Riesgo con código: '.$this->accion->accionable->analisisable->codigo;
        }else{
            $how = 'No Conformidad con código: '.$this->accion->accionable->analisisable->codigo;
        }

        if($this->accion->estado == 'Nuevo'){
            $t = 'Nueva acción de '.$how;
            $type = 'primary';
        }elseif($this->accion->estado == 'En Seguimiento'){
            $t = 'La Acción de '.$how. ' está En Seguimiento.';
            $type = 'info';
        }elseif($this->accion->estado == 'Cerrado'){
            $t = 'La Accion de '.$how. ' fue Cerrada.';
            $type = 'success';
        }

        $url = route('acciones.show', $this->accion->id);

        return [
            'type' => $type,
            'user_id' => auth()->user()->id,
            'username' => auth()->user()->name,
            'text' => $t,
            'url' => $url,
        ];
    }
}
