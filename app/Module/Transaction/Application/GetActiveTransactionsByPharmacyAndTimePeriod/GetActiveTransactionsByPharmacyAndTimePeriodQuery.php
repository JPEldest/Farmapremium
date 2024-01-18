<?php

namespace App\Module\Transaction\Application\GetAllTransactionsByPharmacyAndTimePeriod;

use App\Shared\Application\Query\Query;

class GetActiveTransactionsByPharmacyAndTimePeriodQuery implements Query
{
    public function __construct(private string $pharmacyId, private string $startDate, private string $endDate)
    {
    }

    public static function create(string $pharmacyId, string $startDate, string $endDate)
    {
        return new self($pharmacyId, $startDate, $endDate);
    }

    public function pharmacyId(): string
    {
        return $this->pharmacyId;
    }

    public function startDate(): string
    {
        return $this->startDate;
    }

    public function endDate(): string
    {
        return $this->endDate;
    }
}
