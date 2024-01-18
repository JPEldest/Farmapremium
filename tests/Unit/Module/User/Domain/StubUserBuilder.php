<?php

namespace Tests\Unit\Module\User\Domain;

use App\Module\User\Domain\User;
use App\Module\User\Domain\ValueObject\Balance;
use App\Module\User\Domain\ValueObject\Email;
use App\Module\User\Domain\ValueObject\GivenName;
use App\Module\User\Domain\ValueObject\Surname;
use App\Module\User\Domain\ValueObject\UserId;
use Tests\Unit\Module\User\Domain\ValueObject\StubBalance;
use Tests\Unit\Module\User\Domain\ValueObject\StubEmail;
use Tests\Unit\Module\User\Domain\ValueObject\StubGivenName;
use Tests\Unit\Module\User\Domain\ValueObject\StubSurname;
use Tests\Unit\Module\User\Domain\ValueObject\StubUserId;

class StubUserBuilder
{
    private UserId $id;
    private GivenName $name;
    private Surname $surname;
    private Email $email;
    private Balance $balance;

    private function __construct()
    {
        $this->id = StubUserId::random();
        $this->name = StubGivenName::random();
        $this->surname = StubSurname::random();
        $this->email = StubEmail::random();
        $this->balance = StubBalance::random();
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

    public function withBalance(Balance $balance): self
    {
        $this->balance = $balance;

        return $this;
    }
}
