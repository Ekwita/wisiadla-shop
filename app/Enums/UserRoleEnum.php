<?php

namespace App\Enums;

class UserRoleEnum
{
    const ADMIN = 'Admin';
    const USER = 'User';

    const ROLE = [
        self::ADMIN,
        self::USER
    ];
}
