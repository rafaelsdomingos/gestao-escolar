<?php

namespace App\Filament\Resources\Workshops\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class WorkshopForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('academic_year_id')
                    ->label('Ano letivo')
                    ->relationship('academicYear', 'year')
                    ->required(),
                Select::make('academic_coordination_id')
                    ->label('Coordenação')
                    ->relationship('academicCoordination', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Nome da oficina')
                    ->required()
                    ->rules(
                        fn (callable $get, $record) =>
                            Rule::unique('workshops', 'name')
                                ->where('academic_year_id', $get('academic_year_id'))
                                ->where('academic_coordination_id', $get('academic_coordination_id'))
                                ->ignore($record?->id),
                    )
                    ->validationMessages([
                        'unique' => 'Já existe uma oficina com esse nome neste ano letivo.',
                    ]),
                Datepicker::make('start_date')
                    ->label('Data de início')
                    ->required(),
                Datepicker::make('end_date')
                    ->label('Data de encerramento')
                    ->required(),
                Select::make('shift')
                    ->label('Turno')
                    ->options([
                        'Manhã' => 'Manhã',
                        'Tarde' => 'Tarde',
                        'Noite' => 'Noite'
                    ])
                    ->required(),
                Select::make('user_id')
                    ->label('Professor(a)')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }
}
