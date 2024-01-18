<?php

namespace Tests\Unit\Module\User\Domain\ValueObject;

use App\Module\User\Domain\ValueObject\Surname;
use Faker\Factory;
use Faker\Generator;

class StubSurname
{
    public static function random(): Surname
    {
        $generator = Factory::create();
        $randomSurname = $generator->firstName();
        return Surname::fromString($randomSurname);
    }
}
