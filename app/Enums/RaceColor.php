<?php

namespace App\Enums;

enum RaceColor : string
{
    case BRANCA = 'branca';
    case PRETA = 'preta';
    case PARDA = 'parda';
    case AMARELA = 'amarela';
    case INDIGENA = 'indigena';
    case NAO_DECLARADA = 'nao_declarada';

    public function label(): string
    {
        return match ($this) {
            self::BRANCA => 'Branca',
            self::PRETA => 'Preta',
            self::PARDA => 'Parda',
            self::AMARELA => 'Amarela',
            self::INDIGENA => 'Indígena',
            self::NAO_DECLARADA => 'Não declarada',
        };
    }
}
