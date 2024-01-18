<?php

namespace App\Shared\Domain\ValueObject;

class StringValueObject
{
    protected string $value;

    final protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value)
    {
        return new static($value);
    }

    public function asString(): string
    {
        return $this->value;
    }

    public function equalsTo(StringValueObject $value)
    {
        return $this->value === $value->value;
    }
}
