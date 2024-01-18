<?php

namespace App\Module\User\Infrastructure\Persistence\Mysql;

use App\Module\User\Domain\Read\User;
use App\Module\User\Domain\Read\UserRepository;
use App\Module\User\Domain\ValueObject\UserId;
use Illuminate\Support\Facades\DB;

class MysqlUserReadRepository implements UserRepository
{

    public function ofId(UserId $id): User
    {
        $entry = DB::selectOne('SELECT * FROM users WHERE id = ?', [$id->asString()]);

        return User::create(
            $entry->id,
            $entry->given_name,
            $entry->surname,
            $entry->email,
            $entry->balance
        );
//        return User::create(
//            'nan',
//            'Nan',
//            'Yu',
//            'nan.nodayuyu@gmail.com',
//            200
//        );
    }
}
