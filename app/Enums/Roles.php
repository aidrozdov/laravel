<?php

namespace App\Enums;

enum Roles: string
{
    case ROLE_ADMIN = 'admin';
    case ROLE_SUPER_ADMIN = 'super-admin';
    case ROLE_MANAGER = 'manager';
    case ROLE_USER = 'user';
}
