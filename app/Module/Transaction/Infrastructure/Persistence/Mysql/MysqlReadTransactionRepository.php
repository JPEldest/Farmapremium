<?php

namespace App\Module\Transaction\Infrastructure\Persistence\Mysql;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Module\Transaction\Domain\Read\Transaction;
use App\Module\Transaction\Domain\Read\TransactionRepository;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\ValueObject\UserId;
use Illuminate\Support\Facades\DB;

class MysqlReadTransactionRepository implements TransactionRepository
{

    public function getAllByPharmacyAndTimePeriod(PharmacyId $pharmacyId, string $startDate, string $endDate): array
    {
        $transactions = DB::select("
            SELECT *
            FROM transactions
            WHERE pharmacy_id = ?
            AND created_at BETWEEN ? AND ?
        ", [$pharmacyId->asString(), $startDate, $endDate]);

        foreach ($transactions as $transaction) {
            $transactions[] = Transaction::create(
                $transaction->id,
                $transaction->user_id,
                $transaction->pharmacy_id,
                $transaction->points,
                $transaction->transaction_type
            );
        }
        return $transactions;
    }

    public function getTransactionsByPharmacyUserAndType(PharmacyId $pharmacyId, UserId $userId,TransactionType $transactionType):array
    {
        $transactions = DB::select("
            SELECT *
            FROM transactions
            WHERE pharmacy_id = ?
            AND user_id = ?
            AND transaction_type = ?
        ", [$pharmacyId->asString(), $userId->asString(), $transactionType->value]);

        foreach ($transactions as $transaction) {
            $transactions[] = Transaction::create(
                $transaction->id,
                $transaction->user_id,
                $transaction->pharmacy_id,
                $transaction->points,
                $transaction->transaction_type
            );
        }
        return $transactions;
    }
}
