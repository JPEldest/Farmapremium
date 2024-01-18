<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Command\Command;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Command\Result;
use Illuminate\Bus\Dispatcher;

class CommandBus implements CommandBusInterface
{
    public function __construct(protected Dispatcher $bus)
    {
    }

    public function dispatch(Command $command): Result
    {
        return $this->bus->dispatch($command);
    }

    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}
