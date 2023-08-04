<?php

namespace App\Listeners;

use App\Events\WorkStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\WorkStatusNotification;

class SendWorkStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\WorkStatusChanged  $event
     * @return void
     */
    public function handle(WorkStatusChanged $event)
    {
        $user = $event->work->user; // Tìm người dùng liên quan đến công việc này, giả sử mỗi công việc đều có một người dùng tương ứng
        $user->notify(new WorkStatusNotification($event->work));
    }
}
