<?php

namespace App\Shared\Application\Query;

interface QueryBusInterface
{
    public function query(Query $query): ?Response;
    public function register(array $map): void;
}
