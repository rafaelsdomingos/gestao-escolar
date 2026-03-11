<?php

namespace App\Enums;

enum EnrollStatus : string
{
    case CURSANDO = 'cursando';
    case APROVADO = 'aprovado';
    case REPROVADO = 'reprovado';
    case ABANDONO = 'abandono';
    case TRANCADO = 'trancado';

    public function label(): string
    {
        return match ($this) {
            self::CURSANDO => 'Cursando',
            self::APROVADO => 'Aprovado(a)',
            self::REPROVADO => 'Reprovado(a)',
            self::ABANDONO => 'Abandono',
            self::TRANCADO => 'Trancada'
        };
    }
}
