<?php

namespace Hpolthof\NotaFabriekApi\Models;

use Hpolthof\NotaFabriekApi\Model;

class Invoice extends Model
{
    const SEND_METHOD_EMAIL = 'email';
    const SEND_METHOD_FAX = 'fax';
    const SEND_METHOD_LETTER = 'letter';
    const SEND_METHOD_REGISTERED = 'registered';
    const SEND_METHOD_MANUAL = 'manual';

    protected $_name = 'invoices';

    public $number;
    public $customer_id;
    public $invoice_date;
    public $due_date;
    public $reference;
    public $payment_condition;
    public $items = [];
    public $note;

    public function addItem($description, $price, $quantity = 1, $tax = 21, $discount_percentage = 0, $product_id = null)
    {
        $this->items[] = (object)compact('quantity', 'description', 'price', 'tax', 'discount_percentage', 'product_id');
        return $this;
    }

    public function send($method = self::SEND_METHOD_EMAIL)
    {
        $response = $this->client->request('POST', "{$this->id}/send", compact('method'));
        $result = $this->client->parseResponse($response);

        if ($result !== false) {
            return true;
        }
        return false;
    }
}