<?php

namespace App\Module\User\Domain\ValueObject;

use App\Shared\Domain\ValueObject\StringValueObject;
use http\Exception\InvalidArgumentException;

class Email extends StringValueObject
{
    public static function fromString(string $value): Email
    {
        self::validate($value);

        return new static($value);
    }

    private static function validate(string $email): void
    {
        $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (!preg_match($pattern, $email)) {
            throw new InvalidArgumentException();
        }
    }
}
