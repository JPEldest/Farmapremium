<?php

namespace Tests\Unit\Module\User\Domain\Read;

use App\Module\User\Domain\Read\User;
use Tests\Unit\Module\User\Domain\ValueObject\StubBalance;
use Tests\Unit\Module\User\Domain\ValueObject\StubEmail;
use Tests\Unit\Module\User\Domain\ValueObject\StubGivenName;
use Tests\Unit\Module\User\Domain\ValueObject\StubSurname;
use Tests\Unit\Module\User\Domain\ValueObject\StubUserId;

class StubUserBuilder
{
    private string $id;
    private string $name;
    private string $surname;
    private string $email;
    private int $balance;

    private function __construct()
    {
        $this->id = StubUserId::random()->asString();
        $this->name = StubGivenName::random()->asString();
        $this->surname = StubSurname::random()->asString();
        $this->email = StubEmail::random()->asString();
        $this->balance = StubBalance::random()->asInt();
    }

    public static function create():self
    {
        return new self();
    }

    public function build(): User
    {
        return User::create(
            $this->id,
            $this->name,
            $this->surname,
            $this->email,
            $this->balance
        );
    }

    public function withBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }
}
