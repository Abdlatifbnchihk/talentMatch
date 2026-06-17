<?php

namespace App\Enums;

enum JobOfferStatus: string
{
    case Active = 'active';
    case Closed = 'closed';
}