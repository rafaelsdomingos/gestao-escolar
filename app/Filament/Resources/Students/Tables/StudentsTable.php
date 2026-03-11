<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Enums\RaceColor;
use App\Enums\Gender;
use App\Filament\Exports\StudentExporter;
use Filament\Actions\ExportBulkAction;
use App\Models\Contact;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('birthdate')
                    ->date('d/m/Y')
                    ->label('Nascimento'),
                TextColumn::make('cel_number')
                    ->label('Celular/Whatsapp'),
                TextColumn::make('contacts.name')
                    ->listWithLineBreaks()
                    ->limitList(1)
                    ->expandableLimitedList()
                    ->label('Contato'),
                TextColumn::make('contacts.phone')
                    ->limitList(1)
                    ->expandableLimitedList()
                    ->listWithLineBreaks()
                    ->label('Fone'),
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
                ExportBulkAction::make()
                    ->label('Exportar dados selecionados')
                    ->icon('heroicon-o-table-cells')
                    ->exporter(StudentExporter::class),
            ]);
    }
}
