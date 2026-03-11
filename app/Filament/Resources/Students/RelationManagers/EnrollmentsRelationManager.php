<?php

namespace App\Filament\Resources\Students\RelationManagers;

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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\SchoolClass;
use App\Models\Workshop;
use App\Models\AcademicYear;
use App\Enums\EnrollStatus;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Matrículas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('academic_year_id')
                    ->label('Ano letivo')
                    ->columnSpan(3)
                    ->options(
                        AcademicYear::query()
                            ->orderByDesc('year')
                            ->pluck('year', 'id')
                    )
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('enrollable', null))
                    ->required(),

                MorphToSelect::make('enrollable')
                    ->label('Tipo de atividade')
                    ->live()
                    ->disabled(fn (Get $get) => blank($get('academic_year_id')))
                    ->types([

                        Type::make(SchoolClass::class)
                            ->label('Curso')
                            ->titleAttribute('name')
                            ->modifyOptionsQueryUsing(function ($query, Get $get) {
                                $year = $get('academic_year_id');

                                if ($year) {
                                    $query->where('academic_year_id', $year);
                                }
                            })
                            ->getOptionLabelFromRecordUsing(function (SchoolClass $record) {
                                return "{$record->name} - {$record->course->name}";
                            }),

                        Type::make(Workshop::class)
                            ->label('Oficina')
                            ->titleAttribute('name')
                            ->modifyOptionsQueryUsing(function ($query, Get $get) {
                                $year = $get('academic_year_id');

                                if ($year) {
                                    $query->where('academic_year_id', $year);
                                }
                            }),

                    ])
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->native(false)
                    ->required(), 

                DatePicker::make('start_date')
                    ->label('Data de abertura de matrícula')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Data de fechamento de matrícula'),
                Select::make('status')
                    ->label('Status')
                    ->options(
                        collect(EnrollStatus::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->native(false)
                    ->required(),
                Textarea::make('notes')
                    ->label('Observações')
                    ->columnSpan(3)
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('enrollment_id')
            ->columns([
                TextColumn::make('enrollable_type')
                    ->label('Tipo de Atividade')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        SchoolClass::class => 'Curso',
                        Workshop::class => 'Oficina',
                        default => 'Outro',
                    })
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        SchoolClass::class => 'success',
                        Workshop::class => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('enrollable.name')
                    ->label('Turma')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('enrollable.course.name')
                    ->label('Curso')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('Data de matrícula')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('status'),
                TextColumn::make('notes')
                    ->label('Observação')
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->label('Nova matrícula')
                    ->modalHeading('Matricular estudante'),
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
