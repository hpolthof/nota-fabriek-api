<?php

namespace Hpolthof\NotaFabriekApi\Models;

use Hpolthof\NotaFabriekApi\Model;

class InvoicePayment extends Model
{
    protected $_name = null;
    protected $invoice = null;

    public $amount;
    public $description;
    public $paid_at;

    /**
     * @return null|Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param Invoice $invoice
     * @return InvoicePayment
     * @throws \Exception
     */
    public function setInvoice(Invoice $invoice)
    {
        $this->invoice = $invoice;

        if (!$invoice->id) {
            throw new \Exception('Invoice should have an ID. Perhaps the invoice is not yet stored.');
        }

        $this->_name = "invoices/{$invoice->id}/payments";

        return $this;
    }

}