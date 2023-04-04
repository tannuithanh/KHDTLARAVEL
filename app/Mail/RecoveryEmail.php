<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecoveryEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $data = $this->user;
        $number = User::select('recover')->where('email',$data['email'])->get();
        
        return $this->view('emails.recover')->with('number',  $number)
                    ->subject('Thay đổi mật khẩu');
    }
}
