<?php

namespace App\Module\Transaction\Application\GetPointsGivenToUser;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Module\User\Domain\ValueObject\UserId;
use App\Shared\Application\Query\Query;

class GetPointsGivenToUserQuery implements Query
{
    private function __construct(private string $pharmacyId, private string $userId)
    {
    }

    public static function create(string $pharmacyId, string $userId): self
    {
        return new self($pharmacyId, $userId);
    }

    public function pharmacyId(): PharmacyId
    {
        return PharmacyId::fromString($this->pharmacyId);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->userId);
    }
}
