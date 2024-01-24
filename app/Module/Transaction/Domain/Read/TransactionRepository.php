<?php

namespace App\Module\Transaction\Domain\Read;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\ValueObject\UserId;

interface TransactionRepository
{
    public function getAllByPharmacyAndTimePeriod(PharmacyId $pharmacyId, string $startDate, string $endDate):TransactionsArray;
    public function getTransactionsByPharmacyUserAndType(PharmacyId $pharmacyId, UserId $userId,TransactionType $transactionType):TransactionsArray;
}
