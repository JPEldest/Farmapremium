<?php

namespace App\Module\User\Domain\Read;

use App\Shared\Application\Query\Response;

class User implements Response
{
    private function __construct(
        private string $id,
        private string $name,
        private string $surname,
        private string $email,
        private int $balance
    ) {
    }

    public static function create(
        string $id,
        string $name,
        string $surname,
        string $email,
        int $balance
    ): self
    {
        return new self(
             $id,
             $name,
             $surname,
             $email,
             $balance
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function surname(): string
    {
        return $this->surname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function balance(): int
    {
        return $this->balance;
    }


}
