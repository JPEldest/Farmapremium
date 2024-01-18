<?php

namespace Tests\Unit\Module\Transaction\Domain\ValueObject;

use App\Module\Transaction\Domain\ValueObject\Points;

class StubPoints
{
    public static function random(): Points
    {
        return Points::fromInt(random_int(10, 80));
    }

    public static function withPoints(int $balance): Points
    {
        return Points::fromInt($balance);
    }
}
