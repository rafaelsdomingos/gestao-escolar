<?php

namespace App\Enums;

enum EnrollStatus : string
{
    case cursando = 'cursando';
    case aprovado = 'aprovado';
    case reprovado = 'reprovado';
    case abandono = 'abandono';
    case trancado = 'trancado';

    public function label(): string
    {
        return match ($this) {
            self::cursando => 'Cursando',
            self::aprovado => 'Aprovado(a)',
            self::reprovado => 'Reprovado(a)',
            self::abandono => 'Abandono',
            self::trancado => 'Trancada'
        };
    }
}
