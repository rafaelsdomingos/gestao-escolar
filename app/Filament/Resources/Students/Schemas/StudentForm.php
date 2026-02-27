<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Enums\RaceColor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;


class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('social_name')
                    ->label('Nome Social'),
                TextInput::make('nationality')
                    ->label('Nacionalidade')
                    ->required(),
                TextInput::make('birthplace')
                    ->label('Naturalidade'),
                DatePicker::make('birthdate')
                    ->label('Data de Nascimento'),
                TextInput::make('gender')
                    ->label('Gênero'),
                Select::make('race_color')
                    ->label('Raça/Cor')
                    ->options(
                        collect(RaceColor::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->required()
                    ->native(false)
            ]);
    }
}
