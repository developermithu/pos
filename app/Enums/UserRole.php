<?php

namespace App\Enums;

enum UserRole: string
{
    case IS_SUPERADMIN = 'SUPERADMIN';
    case IS_MANAGER = 'MANAGER';
    case IS_CASHIER = 'CASHIER';
    case IS_DEFAULT = 'USER';
}
