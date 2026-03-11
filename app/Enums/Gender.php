<?php

namespace App\Enums;

enum Gender : string
{
    case HOMEM_CIS = 'homemCis';
    case MULHER_CIS = 'mulherCis';
    case HOMEM_TRANS = 'homemTrans';
    case MULHER_TRANS = 'mulherTrans';
    case NAO_BINARIO = 'naoBinario';
    case TRAVESTI = 'travesti';
    case OUTRO = 'outro';

    public function label(): string
    {
        return match ($this) {
            self::HOMEM_CIS => 'Homem Cis',
            self::MULHER_CIS => 'Mulher Cis',
            self::HOMEM_TRANS => 'Homem Transgênero',
            self::MULHER_TRANS => 'Mulher Transgênero',
            self::NAO_BINARIO => 'Não Binário',
            self::TRAVESTI => 'Travesti',
            self::OUTRO => 'Outro'
        };
    }
}
