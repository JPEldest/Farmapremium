<?php

namespace Tests\Unit\Module\User\Domain\ValueObject;

use App\Module\User\Domain\ValueObject\Balance;

class StubBalance
{
    public static function random(): Balance
    {
        return Balance::fromInt(random_int(10, 80));
    }

    public static function ofBalance(int $balance): Balance
    {
        return Balance::fromInt($balance);
    }
}
