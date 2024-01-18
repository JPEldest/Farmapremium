<?php

namespace App\Module\User\Domain\Read;

class NullUser extends User
{
    public function __construct()
    {
    }

    public static function createNull(): User
    {
        return new self();
    }
}
