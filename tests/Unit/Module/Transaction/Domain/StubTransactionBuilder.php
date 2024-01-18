<?php

namespace Tests\Unit\Module\Transaction\Domain;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Module\Transaction\Domain\Transaction;
use App\Module\Transaction\Domain\ValueObject\Points;
use App\Module\Transaction\Domain\ValueObject\TransactionId;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\ValueObject\UserId;
use Tests\Unit\Module\Pharmacy\Domain\ValueObject\StubPharmacyId;
use Tests\Unit\Module\Transaction\Domain\ValueObject\StubPoints;
use Tests\Unit\Module\Transaction\Domain\ValueObject\StubTransactionId;
use Tests\Unit\Module\Transaction\Domain\ValueObject\StubTransactionType;
use Tests\Unit\Module\User\Domain\ValueObject\StubUserId;

class StubTransactionBuilder
{
    private TransactionId $id;
    private UserId $userId;
    private PharmacyId $pharmacyId;
    private Points $points;
    private TransactionType $transactionType;
    private Points $pointsLeft;

    private function __construct()
    {
        $this->id = StubTransactionId::random();
        $this->userId = StubUserId::random();
        $this->pharmacyId = StubPharmacyId::random();
        $this->points = StubPoints::withPoints(50);
        $this->transactionType = StubTransactionType::give();
        $this->pointsLeft = StubPoints::withPoints(50);
    }

    public static function create(): self
    {
        return new self();
    }

    public function build(): Transaction
    {
        return Transaction::create(
            $this->id,
            $this->userId,
            $this->pharmacyId,
            $this->points,
            $this->transactionType,
            $this->pointsLeft
        );
    }

    public function withId(TransactionId $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withUserId(UserId $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function withPharmacyId(PharmacyId $pharmacyId): self
    {
        $this->pharmacyId = $pharmacyId;

        return $this;
    }

    public function withTransactionType(TransactionType $transactionType): self
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    public function withPoints(Points $points): self
    {
        $this->points = $points;
        $this->pointsLeft = $points;

        return $this;
    }
}
