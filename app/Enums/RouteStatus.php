<?php

namespace App\Enums;

enum RouteStatus: string
{
    case PROCESSED = 'processed';
    case PENDING = 'pending';
}
