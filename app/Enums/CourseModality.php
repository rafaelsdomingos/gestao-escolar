<?php

namespace App\Enums;

enum CourseModality : string
{
    case presencial = 'presencial';
    case remoto = 'remoto';
    case hibrido = 'hibrido';

    public function label(): string
    {
        return match ($this) {
            self::presencial => 'Presencial',
            self::remoto => 'Remoto',
            self::hibrido => 'Híbrido',
        };
    }
}
