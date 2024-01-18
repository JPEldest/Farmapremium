<?php

namespace App\Module\User\Application\GetUserBalance;

use App\Module\User\Domain\ValueObject\UserId;
use App\Shared\Application\Query\Query;

final class GetUserBalanceQuery implements Query
{
    private function __construct(private string $userId)
    {
    }

    public static function create(string $userId): self
    {
        return new self($userId);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->userId);
    }
}
