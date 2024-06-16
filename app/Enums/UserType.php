<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case DRV = 'driver';
    case PSNG = 'passenger';
    case MGR = 'mgr';

}
