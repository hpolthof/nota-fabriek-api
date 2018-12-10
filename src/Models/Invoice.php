<?php

namespace Hpolthof\NotaFabriekApi\Models;

use Hpolthof\NotaFabriekApi\Model;

class Invoice extends Model
{
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
}