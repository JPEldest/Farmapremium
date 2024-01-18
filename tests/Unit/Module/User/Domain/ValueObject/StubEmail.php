<?php

namespace Tests\Unit\Module\User\Domain\ValueObject;

use App\Module\User\Domain\ValueObject\Email;
use Faker\Factory;
use Faker\Generator;

class StubEmail
{
    public static function random(): Email
    {
        $generator = Factory::create();
        $randomEmail = $generator->email();
        return Email::fromString($randomEmail);
    }
}
