<?php

namespace App\Events\Income;

use Illuminate\Queue\SerializesModels;

class InvoiceSent
{
    use SerializesModels;

    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param $invoice
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }
}
