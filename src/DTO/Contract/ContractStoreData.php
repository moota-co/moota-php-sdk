<?php

namespace Moota\Moota\DTO\Contract;


use Spatie\DataTransferObject\DataTransferObject;

class ContractStoreData extends DataTransferObject
{
     /** @var string */
    public $invoice_number;
    /** @var numeric */
    public $amount;
    /** @var string */  
    public $payment_method_id;
    /** @var string */
    public $payment_method_type;
    /** @var string */
    public $type = 'PAYMENT';
    /** @var string */
    public $callback_url;
    /** @var int */
    public $increase_total_from_unique_code = 1;
    /** @var int */
    public $start_unique_code = 000;
    /** @var int */
    public $end_unique_code = 999;
    /** @var string */
    public  $expired_date = '';
    /** @var string */
    public  $description = '';
    /** @var object|array */
    public $customer = []; // available empty
     /** @var array */
    public $items = [];// available empty
}