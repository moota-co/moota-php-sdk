<?php

namespace Moota\Moota\DTO\Webhook;

use Spatie\DataTransferObject\DataTransferObject;

class WebhookStoreData extends DataTransferObject
{
    /** @var string  */
    public $url;
    /** @var string  */
    public $secret_token;
    /** @var int  */
    public $start_unique_code;
    /** @var int  */
    public $end_unique_code;
    /** @var string  */
    public $kinds; // enum with 'credit|debit|both'
    /** @var string  */
    public $bank_account_id = ''; // leave blank for all bank can assigment to webhook
}