<?php

namespace App\Shared\Application\Command;

abstract class Result
{
    private ?string $code;
    private ?string $message;

    private bool $successful;

    protected function __construct(
        bool $successful,
        ?string $code,
        ?string $message
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->successful = $successful;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    public function message(): ?string
    {
        return $this->message;
    }

    public function isNull(): bool
    {
        return false;
    }

    public function hasFailed(): bool
    {
        return !$this->successful;
    }
}
