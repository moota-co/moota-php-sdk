<?php

namespace Moota\Moota\DTO\Webhook;

use Spatie\DataTransferObject\DataTransferObject;

class WebhookQueryParameterData extends DataTransferObject
{
    /** @var string  */
    public $url = '';
    /** @var string  */
    public $bank_account_id = '';
    /** @var int  */
    public $page = 1;
    /** @var int  */
    public $per_page = 20;
}