<?php


namespace Moota\Moota\DTO\Transaction;


use Carbon\Traits\Date;
use Spatie\DataTransferObject\DataTransferObject;

class TransactionHistoryData extends DataTransferObject
{
    /** @var int  */
    public $page = 1;
    /** @var string  */
    public $start_date = '';
    /** @var string  */
    public $end_date = '';
}