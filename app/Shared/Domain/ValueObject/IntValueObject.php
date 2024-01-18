<?php

namespace App\Shared\Domain\ValueObject;

class IntValueObject
{
    protected $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function asInt(): int
    {
        return $this->value;
    }

    public function isBiggerThan(IntValueObject $other): bool
    {
        return $this->asInt() > $other->asInt();
    }

    public function equalsTo(IntValueObject $other): bool
    {
        return $this->value === $other->asInt() && get_class($this) === get_class($other);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public static function fromInt(int $int)
    {
        return new static($int);
    }
}
