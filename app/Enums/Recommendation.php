<?php

namespace App\Enums;

enum Recommendation: string
{
    case Convoquer = 'convoquer';
    case Attente = 'attente';
    case Rejeter = 'rejeter';

    public function label(): string
    {
        return match ($this) {
            self::Convoquer => 'Invite to interview',
            self::Attente => 'On hold',
            self::Rejeter => 'Reject',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Convoquer => 'green',
            self::Attente => 'amber',
            self::Rejeter => 'red',
        };
    }
}