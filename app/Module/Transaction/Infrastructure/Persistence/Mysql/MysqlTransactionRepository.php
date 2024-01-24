<?php

namespace App\Module\Transaction\Infrastructure\Persistence\Mysql;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Module\Transaction\Domain\Transaction;
use App\Module\Transaction\Domain\TransactionRepository;
use App\Module\Transaction\Domain\ValueObject\Points;
use App\Module\Transaction\Domain\ValueObject\TransactionId;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\ValueObject\UserId;
use Illuminate\Support\Facades\DB;

class MysqlTransactionRepository implements TransactionRepository
{

    public function create(Transaction $transaction): void
    {
        $create = DB::insert('INSERT INTO transactions (id, user_id, pharmacy_id, points, transaction_type, points_left,created_at, updated_at) VALUES (?,?,?,?,?,?, NOW(), NOW())', [$transaction->id()->asString(), $transaction->userId()->asString(), $transaction->pharmacyId()->asString(), $transaction->points()->asInt(), $transaction->transactionType()->value, $transaction->pointsLeft()->asInt()]);

        if (!$create) {
            throw new InvalidArgumentException();
        }
    }

    public function redeemPoints(Points $points, UserId $userId): void
    {
        $transactions = DB::select('
            SELECT *
            FROM transactions
            WHERE user_id = :user_id
            AND transaction_type = :transaction_type
            AND points_left > 0
            ORDER BY created_at ASC', [
            'user_id' => $userId->asString(),
            'transaction_type' => TransactionType::GIVE->value,
        ]);
        $response = [];
        foreach ($transactions as $transaction) {
            $response[] = Transaction::create(
                TransactionId::fromString($transaction->id),
                UserId::fromString($transaction->user_id),
                PharmacyId::fromString($transaction->pharmacy_id),
                Points::fromInt($transaction->points),
                TransactionType::from($transaction->transaction_type),
                Points::fromInt($transaction->points_left)
            );
        }

        $response = array_values($response);
        while ($points->asInt() > 0 && !empty($response)) {
            $transactionPoints = $response[0]->pointsLeft();

            if ($points->isBiggerThan($transactionPoints))
            {
                $points = Points::fromInt($points->asInt() - $transactionPoints->asInt());
                $pointsLeft = Points::fromInt(0);
                $response[0]->redeemPoints($transactionPoints);
            } else {
                $response[0]->redeemPoints($points);
                $pointsLeft = Points::fromInt($transactionPoints->asInt() - $points->asInt());
                $points = Points::fromInt(0);
            }

            $updateTransaction = Transaction::create(
                $response[0]->id(),
                $response[0]->userId(),
                $response[0]->pharmacyId(),
                $response[0]->points(),
                $response[0]->transactionType(),
                $pointsLeft
            );

            $this->save($updateTransaction);

            array_shift($response);
        }
    }

    public function save(Transaction $transaction): void
    {
        $insert = DB::update('UPDATE transactions SET user_id = ?, pharmacy_id = ?, points = ?, transaction_type = ?, points_left = ?, updated_at = NOW() WHERE id = ?', [$transaction->userId()->asString(), $transaction->pharmacyId()->asString(), $transaction->points()->asInt(), $transaction->transactionType()->value, $transaction->pointsLeft()->asInt(), $transaction->id()->asString()]);

        if (!$insert) {
            throw new InvalidArgumentException();
        }
    }
}
