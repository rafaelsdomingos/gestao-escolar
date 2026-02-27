<?php

namespace App\Filament\Resources\SchoolClasses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class SchoolClassForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->label('Curso')
                    ->relationship('course', 'name')
                    ->native(false)
                    ->required(),
                Select::make('academic_year_id')
                    ->label('Ano letivo')
                    ->relationship('academicYear', 'year')
                    ->native(false)
                    ->required(),
                TextInput::make('name')
                    ->label('Nome da turma')
                    ->required()
                    ->rules(
                        fn (callable $get, $record) =>
                            Rule::unique('school_classes', 'name')
                                ->where('course_id', $get('course_id'))
                                ->where('academic_year_id', $get('academic_year_id'))
                                ->ignore($record?->id),
                    )
                    ->validationMessages([
                        'unique' => 'Já existe uma turma com esse nome neste ano letivo.',
                    ]),
                Select::make('shift')
                    ->label('Turno')
                    ->native(false)
                    ->options([
                        'Manhã' => 'Manhã',
                        'Tarde' => 'Tarde',
                        'Noite' => 'Noite'
                    ])
                    ->required(),
                
                Datepicker::make('start_date')
                    ->label('Data de início')
                    ->required(),
                Datepicker::make('end_date')
                    ->label('Data de encerramento')
                    ->required(),
            ]);
    }
}
