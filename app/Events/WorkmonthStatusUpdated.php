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

class WorkmonthStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $workmonth;
    public $user;

    public function __construct($workmonth)
    {
        $this->workmonth = $workmonth;
        $this->user = Auth::user();
    }

    public function broadcastOn()
    {
        return new Channel('workmonth');
    }

    public function broadcastAs()
    {
        return 'WorkmonthStatusUpdated';
    }

    public function broadcastWith()
    {
        $message = '';
        
        if (($this->user->position_id == 7 && $this->workmonth->status == 2)) {
            $message = "Công việc ngày có nội dung '" . $this->workmonth->categoryDaily . "' đã được '".$this->user->name."' kiểm tra";
        } elseif (($this->user->position_id == 5 || $this->user->position_id == 6) && $this->workmonth->status == 0) {
            $message = "Công việc ngày có nội dung '" . $this->workmonth->categoryDaily . "' đã được '".$this->user->name."' phê duyệt. Mời bạn thực hiện công việc";
        } elseif ($this->workmonth->status == 3) {
            $message = "Công việc ngày có nội dung '" . $this->workmonth->categoryDaily . "' đã bị từ chối. Bạn vui lòng chỉnh sửa lại công việc hoặc tạo công việc mới";
        }
        
        return [
            "workmonth" => $this->workmonth,
            "message" => $message,
        ];
    }
}
