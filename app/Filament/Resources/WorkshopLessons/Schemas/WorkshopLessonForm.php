<?php

namespace App\Filament\Resources\WorkshopLessons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class WorkshopLessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('workshop_id')
                    ->relationship('workshop', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('color'),
                DateTimePicker::make('starts_at')
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->required(),
            ]);
    }
}
