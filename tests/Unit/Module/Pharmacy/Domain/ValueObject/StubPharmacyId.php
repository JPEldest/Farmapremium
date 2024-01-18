<?php

namespace Tests\Unit\Module\Pharmacy\Domain\ValueObject;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use Faker\Provider\Uuid;

class StubPharmacyId
{
    public static function random(): PharmacyId
    {
        return PharmacyId::fromString(Uuid::uuid());
    }

    public static function withId(string $userId): PharmacyId
    {
        return PharmacyId::fromString($userId);
    }
}
