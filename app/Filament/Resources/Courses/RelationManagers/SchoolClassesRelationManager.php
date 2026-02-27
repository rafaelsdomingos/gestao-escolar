<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;
use Filament\Schemas\Components\Utilities\Get;

class SchoolClassesRelationManager extends RelationManager
{
    protected static string $relationship = 'schoolClasses';

    protected static ?string $title = 'Turmas do curso';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('academic_year_id')
                    ->label('Ano letivo')
                    ->relationship('academicYear', 'year')
                    ->native(false)
                    ->required(),
                TextInput::make('name')
                    ->label('Nome da turma')
                    ->required()
                    ->rules([
                        fn (Get $get, $record) =>
                            Rule::unique('school_classes', 'name')
                                ->where('course_id', $this->getOwnerRecord()->id)
                                ->where('academic_year_id', $get('academic_year_id'))
                                ->ignore($record?->id),
                    ])
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('school_class_id')
            ->columns([
                TextColumn::make('academicYear.year')
                    ->label('Ano letivo')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Turma')
                    ->searchable(),
                TextColumn::make('course.name')
                    ->label('Curso')
                    ->searchable(),
                TextColumn::make('shift')
                    ->label('Turno')
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Nova turma')
                    ->modalHeading('Criar nova turma'),
                //AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                //DissociateAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
