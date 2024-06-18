<?php

namespace App\Enums;

enum PassengerStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case ABORTED = 'aborted';
}
