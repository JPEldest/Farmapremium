<?php

namespace Tests\Unit\Module\User\Domain\ValueObject;

use App\Module\User\Domain\ValueObject\GivenName;
use Faker\Factory;

class StubGivenName
{
    public static function random(): GivenName
    {
        $generator = Factory::create();
        $randomName = $generator->name();
        return GivenName::fromString($randomName);
    }
}
