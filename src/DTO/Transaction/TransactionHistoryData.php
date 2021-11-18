<?php


namespace Moota\Moota\DTO\Transaction;


use Carbon\Traits\Date;
use Spatie\DataTransferObject\DataTransferObject;

class TransactionHistoryData extends DataTransferObject
{
    public function __construct(
        public int $page = 1,
        public string $start_date = '',
        public string $end_date = ''
    ){ }
}