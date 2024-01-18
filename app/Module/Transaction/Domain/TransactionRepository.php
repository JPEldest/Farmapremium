<?php

namespace App\Module\Transaction\Domain;

use App\Module\Transaction\Domain\ValueObject\Points;
use App\Module\User\Domain\ValueObject\UserId;

interface TransactionRepository
{
    public function create(Transaction $transaction): void;
    public function redeemPoints(Points $points, UserId $userId): void;

    public function save(Transaction $transaction): void;
}
