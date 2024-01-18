<?php

namespace Tests\Unit\Module\User\Domain\Read;

use App\Module\User\Domain\Read\NullUser;
use App\Module\User\Domain\Read\User;
use App\Module\User\Domain\Read\UserRepository;
use App\Module\User\Domain\ValueObject\UserId;

class InMemoryUserReadRepository implements UserRepository
{
private array $users = [];
    public function ofId(UserId $id): User
    {
        return $this->users[$id->asString()] ?? NullUser::createNull();
    }

    public function save(User $user): void
    {
        $this->users[$user->id()] = $user;
    }
}
