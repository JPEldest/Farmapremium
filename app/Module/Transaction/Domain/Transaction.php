<?php

namespace App\Module\Transaction\Domain;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Module\Transaction\Domain\ValueObject\Points;
use App\Module\Transaction\Domain\ValueObject\TransactionId;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\Exceptions\NotEnoughBalanceException;
use App\Module\User\Domain\ValueObject\UserId;

class Transaction
{
    private function __construct(
        private TransactionId $id,
        private UserId $userId,
        private PharmacyId $pharmacyId,
        private Points $points,
        private TransactionType $transactionType,
        private Points $pointsLeft
    ) {
    }

    public static function create(
        TransactionId $id,
        UserId $userId,
        PharmacyId $pharmacyId,
        Points $points,
        TransactionType $transactionType,
        Points $pointsLeft
    ): self {
        return new self(
            $id,
            $userId,
            $pharmacyId,
            $points,
            $transactionType,
            $pointsLeft
        );
    }

    public function id(): TransactionId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function pharmacyId(): PharmacyId
    {
        return $this->pharmacyId;
    }

    public function points(): Points
    {
        return $this->points;
    }

    public function transactionType(): TransactionType
    {
        return $this->transactionType;
    }

    public function pointsLeft(): Points
    {
        return $this->pointsLeft;
    }

    public function redeemPoints(Points $pointsRedeemed) : void
    {
        if ($pointsRedeemed->isBiggerThan($this->pointsLeft)) {
            throw new NotEnoughBalanceException();
        }
        $this->pointsLeft = Points::fromInt($this->pointsLeft->asInt() - $pointsRedeemed->asInt());
    }
}
