<?php

namespace Tests\Unit\Module\User\Domain;

use App\Module\User\Domain\User;
use App\Module\User\Domain\UserRepository;
use App\Module\User\Domain\ValueObject\UserId;

class InMemoryWriteUserRepository implements UserRepository
{
private $users = [];
    public function save(User $user): void
    {
        $this->users[$user->id()->asString()] = $user;
    }

    public function ofId(UserId $userId): User
    {
        return $this->users[$userId->asString()];
    }
}
