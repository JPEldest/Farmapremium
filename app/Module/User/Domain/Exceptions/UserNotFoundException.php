<?php

namespace App\Module\User\Domain\Exceptions;

use App\Module\User\Domain\ValueObject\UserId;

class UserNotFoundException extends \Exception
{
    protected const TYPE = 'user.not_found';

    public static function ofId(UserId $userId): self
    {
        return new self(sprintf('User of id <%s> not exists', $userId->asString()));
    }
}
