<?php

namespace App\Enums;

enum CandidateStatus: string
{
    case Pending = 'pending';
    case Analyzed = 'analyzed';
}
