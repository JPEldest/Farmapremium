<?php

namespace App\Shared\Application\Command;

interface CommandBusInterface
{
    public function dispatch(Command $command): Result;

    public function register(array $map): void;
}
