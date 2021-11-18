<?php


namespace Moota\Moota\DTO\Topup;


use Spatie\DataTransferObject\DataTransferObject;

class ManualConfirmationTopupData extends DataTransferObject
{
    public function __construct(
        public string $topup_id,
        public $file
    ){  }

}