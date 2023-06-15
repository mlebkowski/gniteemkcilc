<?php

declare(strict_types=1);

namespace App\Domain\User;

final class UserMother
{
    public static function some(): User
    {
        return new User('');
    }
}