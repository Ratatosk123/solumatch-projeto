<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordLink extends Notification
{
    use Queueable;

    protected string $link;

    public function __construct(string $link)
    {
        $this->link = $link;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Redefinição de Senha – SoluMatch')
            ->greeting('Olá!')
            ->line('Recebemos seu pedido para redefinir a senha.')
            ->action('Redefinir senha agora', $this->link)
            ->line('Se você não solicitou, ignore esta mensagem.');
    }
}
