<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;
    public $tableData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tableData)
    {
        $this->tableData = $tableData;
    }
     public function build()
    {
        $myDate = date('Y-m-d');
        $today = date('d/m/Y', strtotime($myDate));
        $user = Auth::user();
        dd($this->tableData);
        return $this->markdown('emails.report')->with('tableData', $this->tableData)->with('user',$user)->with('today',$today);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $myDate = date('Y-m-d');
        $today = date('d/m/Y', strtotime($myDate));
        return new Envelope(
            subject: 'BÁO CÁO KẾ HOẠCH NGÀY '.$today,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
