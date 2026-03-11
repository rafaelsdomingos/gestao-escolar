<?php

namespace App\Enums;

enum EducationLevel : string
{
    case NENHUMA = 'nenhuma';
    case FUNDAMENTAL_INCOMPLETO = 'fundamental_incompleto';
    case FUNDAMENTAL_COMPLETO = 'fundamental_completo';
    case MEDIO_INCOMPLETO = 'medio_incompleto';
    case MEDIO_COMPLETO = 'medio_completo';
    case TECNICO = 'tecnico';
    case SUPERIOR_INCOMPLETO = 'superior_incompleto';
    case SUPERIOR_COMPLETO = 'superior_completo';
    case POS_GRADUACAO = 'pos_graduacao';
    case MESTRADO = 'mestrado';
    case DOUTORADO = 'doutorado';

    public function label(): string
    {
        return match ($this) {
            self::NENHUMA => 'Nenhuma',
            self::FUNDAMENTAL_INCOMPLETO => 'Ensino Fundamental Incompleto',
            self::FUNDAMENTAL_COMPLETO => 'Ensino Fundamental Completo',
            self::MEDIO_INCOMPLETO => 'Ensino Médio Incompleto',
            self::MEDIO_COMPLETO => 'Ensino Médio Completo',
            self::TECNICO => 'Ensino Técnico',
            self::SUPERIOR_INCOMPLETO => 'Ensino Superior Incompleto',
            self::SUPERIOR_COMPLETO => 'Ensino Superior Completo',
            self::POS_GRADUACAO => 'Pós-graduação',
            self::MESTRADO => 'Mestrado',
            self::DOUTORADO => 'Doutorado',
        };
    }
}
