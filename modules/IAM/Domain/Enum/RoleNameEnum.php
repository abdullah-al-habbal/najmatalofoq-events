<?php
// modules/IAM/Domain/Enum/RoleNameEnum.php

declare(strict_types=1);

namespace Modules\IAM\Domain\Enum;

enum RoleNameEnum: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case SUPERVISOR = 'supervisor';
    case EMPLOYEE = 'employee';
}
