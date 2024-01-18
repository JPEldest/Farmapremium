<?php

namespace Tests\Unit\Module\Transaction\Domain\ValueObject;

use App\Module\Transaction\Domain\ValueObject\TransactionId;
use Faker\Provider\Uuid;

class StubTransactionId
{
    public static function random(): TransactionId
    {
        return TransactionId::fromString(Uuid::uuid());
    }

    public static function withId(string $userId): TransactionId
    {
        return TransactionId::fromString($userId);
    }
}
