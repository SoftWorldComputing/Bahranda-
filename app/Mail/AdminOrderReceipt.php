<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOrderReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $commodity;
    public $user;
    public $deal;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($commodity,$user,$deal)
    {
        //
        $this->user = $user;
        $this->commodity = $commodity;
        $this->deal = $deal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.order.admin_receipt');
    }
}
