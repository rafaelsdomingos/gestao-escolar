<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                    
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),

                TextInput::make('password')
                    ->label("Senha")
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state)) // só salva se preenchido
                    ->revealable()
                    ->maxLength(30),

                CheckboxList::make('academic_coordination_id')
                    ->label('Coordenações')
                    ->relationship('academicCoordinations', 'code')
                    ->getOptionLabelFromRecordUsing(
                        fn ($record) => "{$record->code} - {$record->name}"
                    )
                    ->columnSpan(2),
                
                CheckboxList::make('roles')
                    ->label('Funções')
                    ->relationship('roles', 'name'),
            ]);
    }
}
