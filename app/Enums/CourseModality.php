<?php

namespace App\Enums;

enum CourseModality : string
{
    case PRESENCIAL = 'presencial';
    case REMOTO = 'remoto';
    case HIBRIDO = 'hibrido';

    public function label(): string
    {
        return match ($this) {
            self::PRESENCIAL => 'Presencial',
            self::REMOTO => 'Remoto',
            self::HIBRIDO => 'Híbrido',
        };
    }
}
