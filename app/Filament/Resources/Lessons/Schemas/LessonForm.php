<?php

namespace App\Filament\Resources\Lessons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\ColorPicker;
use Filament\Schemas\Schema;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subject_class_id')
                    ->relationship('subjectClass', 'id')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                ColorPicker::make('color'),
                DateTimePicker::make('starts_at')
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->required(),
            ]);
    }
}
