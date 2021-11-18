<?php

namespace Moota\Moota\DTO\Webhook;

use Spatie\DataTransferObject\DataTransferObject;

class WebhookQueryParameterData extends DataTransferObject
{

    public function __construct(
        public string $url = '',
        public string $bank_account_id = '',
        public int $page = 1,
        public int $per_page = 20,
    ) { }
}