<?php

namespace App\Filament\Resources\WorkshopLessons\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'workshopAttendances';

    protected static ?string $title = 'Lista de frequência';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required(),
                Toggle::make('is_present')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('student.name')
                    ->label('Estudante'),
                IconColumn::make('is_present')
                    ->label('Presença')
                    ->boolean(),
                // TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //CreateAction::make(),
                //AssociateAction::make(),
                Action::make('attendance')
                    ->label('Marcar frequência')
                    ->icon(Heroicon::OutlinedCheck)
                    ->url(fn ($record) => route('filament.pages.register-workshop-attendance', [
                        'workshop_lesson_id' => $this->ownerRecord->id,
                    ]))

            ])
            ->recordActions([
                EditAction::make(),
                //DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
