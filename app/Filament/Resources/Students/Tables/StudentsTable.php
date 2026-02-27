<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Enums\RaceColor;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                //TextColumn::make('social_name')
                //    ->label('Nome Social')
                //    ->searchable(),
                TextColumn::make('nationality')
                    ->label('Nacionalidade')
                    ->searchable(),
                TextColumn::make('birthplace')
                    ->label('Naturalidade')
                    ->searchable(),
                TextColumn::make('birthdate')
                    ->label('Data de Nascimento')
                    ->date('d/m/Y')
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Gẽnero')
                    ->searchable(),
                TextColumn::make('race_color')
                    ->label('Raça/Cor')
                    ->searchable()
                    ->formatStateUsing(fn (?RaceColor $state) => $state?->label()),
                TextColumn::make('created_at')
                    ->label('Data de criação')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Data de atualização')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
