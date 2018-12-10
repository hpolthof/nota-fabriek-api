<?php

namespace Hpolthof\NotaFabriekApi\Models;

use Hpolthof\NotaFabriekApi\HasProperties;
use Hpolthof\NotaFabriekApi\Model;

class Product extends Model
{
    use HasProperties;

    protected $_name = 'products';

    public $name;
    public $tax;
    public $price;
}