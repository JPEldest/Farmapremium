<?php

namespace App\Module\Transaction\Application\CreateTransaction;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Module\Transaction\Domain\ValueObject\Points;
use App\Module\Transaction\Domain\ValueObject\TransactionId;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\ValueObject\UserId;
use App\Shared\Application\Command\Command;

class CreateTransactionCommand implements Command
{
    private function __construct(
        private string $transactionId,
        private string $pharmacyId,
        private string $userId,
        private int $points,
        private string $transactionType,
        private int $points_left
    ) {
    }

    public static function create(
        string $transactionId,
        string $pharmacyId,
        string $userId,
        int $points,
        string $transactionType,
        int $points_left
    ): self {
        return new self(
            $transactionId,
            $pharmacyId,
            $userId,
            $points,
            $transactionType,
            $points_left
        );
    }

    public function transactionId(): TransactionId
    {
        return TransactionId::fromString($this->transactionId);
    }

    public function pharmacyId(): PharmacyId
    {
        return PharmacyId::fromString($this->pharmacyId);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->userId);
    }

    public function points(): Points
    {
        return Points::fromInt($this->points);
    }

    public function transactionType(): TransactionType
    {
        return TransactionType::from($this->transactionType);
    }

    public function pointsLeft(): Points
    {
        return Points::fromInt($this->points_left);
    }
}
