<?php

namespace Moota\Moota\DTO\Contract;

use Spatie\DataTransferObject\DataTransferObject;

class ContractStoreData extends DataTransferObject
{
    public string $invoice_number;

    public $amount;

    public string $payment_method_id;

    public string $payment_method_type;

    public string $type = 'PAYMENT';

    public string $callback_url;

    public $increase_total_from_unique_code = 1;

    public $start_unique_code = 000;

    public $end_unique_code = 999;

    public string $expired_date = '';

    public string $description = '';

    public $customer = [];

    public $items = [];
}