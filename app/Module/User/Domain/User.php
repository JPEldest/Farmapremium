<?php

namespace App\Module\User\Domain;

use App\Module\User\Domain\Exceptions\NotEnoughBalanceException;
use App\Module\User\Domain\ValueObject\Balance;
use App\Module\User\Domain\ValueObject\Email;
use App\Module\User\Domain\ValueObject\GivenName;
use App\Module\User\Domain\ValueObject\Surname;
use App\Module\User\Domain\ValueObject\UserId;

class User
{
    private UserId $id;
    private GivenName $name;
    private Surname $surname;
    private Email $email;
    private Balance $balance;

    private function __construct(
        UserId $id,
        GivenName $name,
        Surname $surname,
        Email $email,
        Balance $balance
    ) {
        $this->balance = $balance;
        $this->surname = $surname;
        $this->name = $name;
        $this->id = $id;
        $this->email = $email;
    }

    public static function create(
        UserId $id,
        GivenName $name,
        Surname $surname,
        Email $email,
        Balance $balance
    ): self {
        return new self(
            $id,
            $name,
            $surname,
            $email,
            $balance
        );
    }
    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): GivenName
    {
        return $this->name;
    }

    public function surname(): Surname
    {
        return $this->surname;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function balance(): Balance
    {
        return $this->balance;
    }

    public function gatherPoints(Balance $increase): void
    {
        $newBalance = $this->balance->asInt()+$increase->asInt();

        $this->balance = Balance::fromInt($newBalance);
    }

    public function redeemPoints(Balance $pointsToRedeem): void
    {
        if ($pointsToRedeem->isBiggerThan($this->balance))
        {
            throw new NotEnoughBalanceException();
        }

        $newBalance = $this->balance->asInt()-$pointsToRedeem->asInt();

        $this->balance = Balance::fromInt($newBalance);
    }
}
