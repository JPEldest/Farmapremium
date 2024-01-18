<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Query\Query;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Application\Query\Response;
use Illuminate\Bus\Dispatcher;

class QueryBus implements QueryBusInterface
{
    public function __construct(protected Dispatcher $bus)
    {
    }
    public function query(Query $query): ?Response
    {
        return $this->bus->dispatch($query);
    }

    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}
