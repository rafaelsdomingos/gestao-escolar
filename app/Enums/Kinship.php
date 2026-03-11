<?php

namespace App\Enums;

enum Kinship: string
{
    case FATHER = 'father';
    case MOTHER = 'mother';
    case BROTHER = 'brother';
    case SISTER = 'sister';
    case GRANDFATHER = 'grandfather';
    case GRANDMOTHER = 'grandmother';
    case UNCLE = 'uncle';
    case AUNT = 'aunt';
    case STEPFATHER = 'stepfather';
    case STEPMOTHER = 'stepmother';
    case PARTNER_MALE = 'partner_male';
    case PARTNER_FEMALE = 'partner_female';
    case NEIGHBOR_MALE = 'neighbor_male';
    case NEIGHBOR_FEMALE = 'neighbor_female';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::FATHER => 'Pai',
            self::MOTHER => 'Mãe',
            self::BROTHER => 'Irmão',
            self::SISTER => 'Irmã',
            self::GRANDFATHER => 'Avô',
            self::GRANDMOTHER => 'Avó',
            self::UNCLE => 'Tio',
            self::AUNT => 'Tia',
            self::STEPFATHER => 'Padrasto',
            self::STEPMOTHER => 'Madrasta',
            self::PARTNER_MALE => 'Companheiro',
            self::PARTNER_FEMALE => 'Companheira',
            self::NEIGHBOR_MALE => 'Vizinho',
            self::NEIGHBOR_FEMALE => 'Vizinha',
            self::OTHER => 'Outro',
        };
    }
}
