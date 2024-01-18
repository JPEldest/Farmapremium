<?php

namespace App\Module\User\Infrastructure\Persistence\Mysql;

use App\Module\User\Domain\User;
use App\Module\User\Domain\UserRepository;
use App\Module\User\Domain\ValueObject\Balance;
use App\Module\User\Domain\ValueObject\Email;
use App\Module\User\Domain\ValueObject\GivenName;
use App\Module\User\Domain\ValueObject\Surname;
use App\Module\User\Domain\ValueObject\UserId;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;

class MysqlUserWriteRepository implements UserRepository
{
    public function save(User $user): void
    {
        $insert = DB::update('UPDATE users SET given_name = ?, surname = ?, email = ?, balance = ?, updated_at = NOW() WHERE id = ?', [$user->name()->asString(), $user->surname()->asString(), $user->email()->asString(), $user->balance()->asInt(), $user->id()->asString()]);

        if (!$insert) {
            throw new InvalidArgumentException();
        }
    }

    public function ofId(UserId $userId): User
    {
        $entry = DB::selectOne('SELECT * FROM users WHERE id = ?', [$userId->asString()]);

        return User::create(
            UserId::fromString($entry->id),
            GivenName::fromString($entry->given_name),
            Surname::fromString($entry->surname),
            Email::fromString($entry->email),
            Balance::fromInt($entry->balance)
        );

//        return User::create(
//            UserId::fromString('w.nan'),
//            GivenName::fromString('Nan'),
//            Surname::fromString('Yu'),
//            Email::fromString('nan.nodayuyu@gmail.com'),
//            Balance::fromInt(200)
//        );
    }
}
