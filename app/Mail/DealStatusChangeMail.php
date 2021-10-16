<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DealStatusChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $deal;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$deal,$status)
    {
        //
        $this->user = $user;
        $this->deal = $deal;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->mail('emails.order.status_change');
    }
}
