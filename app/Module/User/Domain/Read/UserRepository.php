<?php

namespace App\Module\User\Domain\Read;

use App\Module\User\Domain\ValueObject\UserId;

interface UserRepository
{
    public function ofId(UserId $id): User;
}
