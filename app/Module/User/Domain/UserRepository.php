<?php

namespace App\Module\User\Domain;

use App\Module\User\Domain\ValueObject\UserId;

interface UserRepository
{
    public function save(User $user): void;
    public function ofId(UserId $userId): User;
}
