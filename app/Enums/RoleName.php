<?php

namespace App\Enums;

enum RoleName: string
{
    case ADMIN = 'admin';
    case PSNG = 'psng'; //passenger
    case DRV = 'drv'; //driver

    case MGR = 'mgr'; //mgr
}
