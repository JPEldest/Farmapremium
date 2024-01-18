<?php

declare(strict_types=1);

namespace App\Module\User\Domain\Read;

use App\Module\User\Domain\Exceptions\UserNotFoundException;
use App\Module\User\Domain\ValueObject\UserId;

class UserFinder
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(UserId $userId): User
    {
        $user = $this->userRepository->ofId($userId);

        if ($user instanceof NullUser) {
            throw UserNotFoundException::ofId($userId);
        }

        return $user;
    }
}
