<?php

namespace App\Module\User\Domain;

use App\Module\User\Domain\ValueObject\UserId;

class UserFinder
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(UserId $userId): User
    {
        return $this->userRepository->ofId($userId);
    }
}
