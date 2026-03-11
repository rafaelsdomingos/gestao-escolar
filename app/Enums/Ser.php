<?php

namespace App\Enums;

enum SER : string
{
    case SER0 = '0';
    case SER1 = '1';
    case SER2 = '2';
    case SER3 = '3';
    case SER4 = '4';
    case SER5 = '5';
    case SER6 = '6';
    case SER7 = '7';
    case SER8 = '8';
    case SER9 = '9';
    case SER10 = '10';
    case SER11 = '11';
    case SER12 = '12';

    public function label(): string
    {
        return match ($this) {
            self::SER0 => 'Outros municípios',
            self::SER1 => 'SER I',
            self::SER2 => 'SER II',
            self::SER3 => 'SER III',
            self::SER4 => 'SER IV',
            self::SER5 => 'SER V',
            self::SER6 => 'SER VI',
            self::SER7 => 'SER VII',
            self::SER8 => 'SER VIII',
            self::SER9 => 'SER IX',
            self::SER10 => 'SER X',
            self::SER11 => 'SER XI',
            self::SER12 => 'SER XII',
        };
    }
}
