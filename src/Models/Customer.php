<?php

namespace Hpolthof\NotaFabriekApi\Models;

use Hpolthof\NotaFabriekApi\HasProperties;
use Hpolthof\NotaFabriekApi\Model;

class Customer extends Model
{
    use HasProperties;

    protected $_name = 'customers';

    public $company_name;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $kvk_nr;
    public $tax_id;
    public $street;
    public $housenumber;
    public $housenumber_extension;
    public $postcode;
    public $city;
    public $country;
    public $email;
    public $phone;
    public $fax;
    public $payment_condition;
}