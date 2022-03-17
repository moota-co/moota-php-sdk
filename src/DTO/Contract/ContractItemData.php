<?php
namespace Moota\Moota\DTO\Contract;

use Spatie\DataTransferObject\DataTransferObject;

class ContractItemData extends DataTransferObject
{
    public $name;
     /** @var string */
    public $sku;
     /** @var int */
    public $price;
     /** @var string */
    public $qty;
     /** @var string */
    public $image_url = '';
     /** @var string */
    public $description = '';
}
