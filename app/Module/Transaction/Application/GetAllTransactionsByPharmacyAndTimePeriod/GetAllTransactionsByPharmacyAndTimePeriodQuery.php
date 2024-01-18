<?php

namespace App\Module\Transaction\Application\GetAllTransactionsByPharmacyAndTimePeriod;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Shared\Application\Query\Query;

class GetAllTransactionsByPharmacyAndTimePeriodQuery implements Query
{
    public function __construct(private string $pharmacyId, private string $startDate, private string $endDate)
    {
    }

    public static function create(string $pharmacyId, string $startDate, string $endDate)
    {
        return new self($pharmacyId, $startDate, $endDate);
    }

    public function pharmacyId(): PharmacyId
    {
        return PharmacyId::fromString($this->pharmacyId);
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
