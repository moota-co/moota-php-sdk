<?php

namespace Moota\Moota\DTO\Contract;

use Spatie\DataTransferObject\DataTransferObject;

class ContractItemData extends DataTransferObject
{
        public string $name;
        public string $sku;
        public int $price;
        public string $qty;
        public string $image_url = '';
        public string $description = '';
        public string $contract_id = '';
        public string $product_id = '';
}