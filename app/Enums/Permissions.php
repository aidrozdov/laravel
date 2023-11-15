<?php

namespace App\Enums;

enum Permissions: string
{
    case COMPANY_CREATE = 'company-create';
    case COMPANY_EDIT = 'company-edit';
    case COMPANY_VIEW = 'company-view';
    case COMPANY_CHANGE_TARIFF = 'change-tariff';
    case USER_CREATE = 'user-create';
    case USER_VIEW = 'user-view';
    case USER_EDIT = 'user-edit';
    case USER_DELETE = 'user-delete';
    case USER_CHANGE_PASSWORD = 'user-change-password';
    case USER_PERMISSIONS = 'user-permissions';
}
