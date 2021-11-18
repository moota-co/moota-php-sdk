<?php

namespace Moota\Moota\DTO\Webhook;

use Spatie\DataTransferObject\DataTransferObject;

class WebhookStoreData extends DataTransferObject
{
    public function __construct(
        public string $url,
        public string $secret_token,
        public int $start_unique_code,
        public int $end_unique_code,
        public string $kinds, // enum with 'credit|debit|both'
        public string $bank_account_id = '' // leave blank for all bank can assigment to webhook
    ) { }


}