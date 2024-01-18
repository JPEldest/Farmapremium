<?php

namespace App\Module\Transaction\Domain\Read;

class Transaction
{
    private function __construct(
        private string $id,
        private string $userId,
        private string $pharmacyId,
        private int $points,
        private string $transactionType
    ) {
    }

    public static function create(
        string $id,
        string $userId,
        string $pharmacyId,
        int $points,
        string $transactionType
    ): self {
        return new self(
            $id,
            $userId,
            $pharmacyId,
            $points,
            $transactionType
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getPharmacyId(): string
    {
        return $this->pharmacyId;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }
}
