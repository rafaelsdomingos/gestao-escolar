<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Enums\CourseModality;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('academic_coordination_id')
                    ->relationship('academicCoordination', 'name')
                    ->label('Coordenação')
                    ->native(false)
                    ->required(),
                TextInput::make('name')
                    ->label('Nome')
                    ->unique()
                    ->required(),
                Select::make('modality')
                    ->label('Modalidade')
                    ->options(
                        collect(CourseModality::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->required()
                    ->native(false),
                TextInput::make('description')
                    ->label('Descrição')
                    ->unique()
                    ->required(),
            ]);
    }
}
