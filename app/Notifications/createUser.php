<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class createUser extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($newUserData)
    {
        $this->newUserData = $newUserData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->buildMailMessage($this->newUserData);
    }

    protected function buildMailMessage($newUserData)
    {
        return (new MailMessage)
            ->subject('Вы добавлены в ' . config('app.name'))
            ->greeting('Здравствуйте, ' . $newUserData['name'] . ' !')
            ->line('Ваш логин: ' . $newUserData['email'])
            ->line('Пароль: ' . $newUserData['password'])
            ->action('Перейти в  ' . config('app.name'), config('app.url'))
            ->line(('Если вы не создавали учетную запись, никаких дальнейших действий не требуется'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
