<?php

namespace App\Enums;

enum RaceColor : string
{
    case branca = 'branca';
    case preta = 'preta';
    case parda = 'parda';
    case amarela = 'amarela';
    case indigena = 'indigena';
    case nao_declarada = 'nao_declarada';

    public function label(): string
    {
        return match ($this) {
            self::branca => 'Branca',
            self::preta => 'Preta',
            self::parda => 'Parda',
            self::amarela => 'Amarela',
            self::indigena => 'Indígena',
            self::nao_declarada => 'Não declarada',
        };
    }
}
