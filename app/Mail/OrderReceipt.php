<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $commodity;
    public $user;
    public $deal;
    public $transaction_ref;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($commodity, $user, $deal, $transaction_ref)
    {
        //
        $this->user = $user;
        $this->commodity = $commodity;
        $this->deal = $deal;
        $this->transaction_ref = $transaction_ref;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.order.receipt');
    }
}
