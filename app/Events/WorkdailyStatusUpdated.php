<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class WorkdailyStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $workdaily;
    public $user;

    public function __construct($workdaily)
    {
        $this->workdaily = $workdaily;
        $this->user = Auth::user();
    }

    public function broadcastOn()
    {
        return new Channel('workdaily');
    }

    public function broadcastAs()
    {
        return 'WorkdailyStatusUpdated';
    }

    public function broadcastWith()
    {
        $message = '';

        if (($this->user->position_id == 7 && $this->workdaily->status == 2)) {
            $message = "Công việc ngày có nội dung '" . $this->workdaily->categoryDaily . "' đã được '".$this->user->name."' kiểm tra";
        } elseif (($this->user->position_id == 5 || $this->user->position_id == 6) && $this->workdaily->status == 0) {
            $message = "Công việc ngày có nội dung '" . $this->workdaily->categoryDaily . "' đã được '".$this->user->name."' phê duyệt. Mời bạn thực hiện công việc";
        } elseif ($this->workdaily->status == 3) {
            $message = "Công việc ngày có nội dung '" . $this->workdaily->categoryDaily . "' đã bị từ chối. Bạn vui lòng chỉnh sửa lại công việc hoặc tạo công việc mới";
        }
        
        return [
            "workdaily" => $this->workdaily,
            "message" => $message,
        ];
    }
}
