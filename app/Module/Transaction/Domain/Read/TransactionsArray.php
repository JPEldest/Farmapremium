<?php

namespace App\Module\Transaction\Domain\Read;

use App\Shared\Application\Query\Response;

class TransactionsArray implements Response
{
    private function __construct(private array $data)
    {
    }

    public static function create(array $data):self
    {
        return new self(
            $data
        );
    }

    public function getData(): array
    {
        return $this->data;
    }
}
