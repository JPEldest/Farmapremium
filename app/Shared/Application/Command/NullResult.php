<?php

namespace App\Shared\Application\Command;

class NullResult extends Result
{
    protected function __construct()
    {
    }

    public static function create(): NullResult
    {
        return new self();
    }

    public function code(): string
    {
        throw new \BadMethodCallException();
    }

    public function message(): string
    {
        throw new \BadMethodCallException();
    }

    public function isNull(): bool
    {
        return true;
    }

    public function hasFailed(): bool
    {
        return false;
    }
}
