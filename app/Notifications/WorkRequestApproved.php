<?php

namespace App\Notifications;

use App\Models\WorkRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkRequestApproved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
     
    protected $workRequest;
    
     
    public function __construct()
    {
        $this->workRequest = $workRequest;
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
        return (new MailMessage)
            ->line('作業依頼が承認されました。')
            ->action('詳細を表示', url('/work-requests/' . $this->workRequest->id))
            ->line('ありがとうございます！');
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
            'work_request_id' => $this->workRequest->id,
            'message' => '作業依頼が承認されました。'
        ];
    }
}
