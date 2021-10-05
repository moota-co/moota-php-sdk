<?php


namespace Moota\Moota\DTO\Topup;


use Spatie\DataTransferObject\DataTransferObject;

class ManualConfirmationTopupData extends DataTransferObject
{
    /** @var string  */
    public $topup_id;
    public $file;
}