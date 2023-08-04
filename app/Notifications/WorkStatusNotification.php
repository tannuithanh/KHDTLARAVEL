<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkStatusNotification extends Notification
{
    use Queueable;

    protected $work; // Khai báo thuộc tính 'work'

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($work) // Thêm biến $work vào hàm tạo
    {
        $this->work = $work; // Gán giá trị cho thuộc tính 'work'
    }

    // ...

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
    public function toDatabase($notifiable)
    {
        return [
            'work' => $this->work,
        ];
    }
}
