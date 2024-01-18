<?php

namespace Tests\Unit\Module\User\Domain\ValueObject;

use App\Module\User\Domain\ValueObject\UserId;
use Faker\Provider\Uuid;

class StubUserId
{
    public static function random(): UserId
    {
        return UserId::fromString(Uuid::uuid());
    }

    public static function withId(string $userId): UserId
    {
        return UserId::fromString($userId);
    }
}
