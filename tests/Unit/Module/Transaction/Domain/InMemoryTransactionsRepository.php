<?php

namespace Tests\Unit\Module\Transaction\Domain;

use App\Module\Transaction\Domain\Transaction;
use App\Module\Transaction\Domain\TransactionRepository;
use App\Module\Transaction\Domain\ValueObject\Points;
use App\Module\Transaction\Domain\ValueObject\TransactionId;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\ValueObject\UserId;

class InMemoryTransactionsRepository implements TransactionRepository
{
private array $transactions = [];

    public function create(Transaction $transaction): void
    {
        $this->transactions[$transaction->id()->asString()] = $transaction;
    }

    public function redeemPoints(Points $points, UserId $userId): void
    {
        $list = array_filter(
            $this->transactions,
            function (Transaction $transaction) use ($userId) {
                return $transaction->userId() ->asString() === $userId->asString() && $transaction->pointsLeft()->asInt() >0;
            }
        );

        $list = array_values($list);
        while ($points->asInt() > 0 && !empty($list)) {
            $transactionPoints = $list[0]->pointsLeft();
            if ($points->isBiggerThan($transactionPoints))
            {
                $points = Points::fromInt($points->asInt() - $transactionPoints->asInt());
                $list[0]->redeemPoints($transactionPoints);
            } else {
                $list[0]->redeemPoints($points);
            }

            $updateTransaction = Transaction::create(
                $list[0]->id(),
                $list[0]->userId(),
                $list[0]->pharmacyId(),
                $list[0]->points(),
                $list[0]->transactionType(),
                $points
            );

            $this->save($updateTransaction);

            array_shift($list);
        }
    }

    public function save(Transaction $transaction): void
    {
        $this->transactions[$transaction->id()->asString()] = $transaction;
    }
}
