<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionDataMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = array())
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->view('view.name');
        $data = $this->data;
        $message = $this;
        $messageSubject = "Info";
        
        $message = $message->subject( $messageSubject );
        $message = $message->view('mails.transaction_data_mail')->with([
            'data' => $data
        ]);
        
        return $message;
    }
}
