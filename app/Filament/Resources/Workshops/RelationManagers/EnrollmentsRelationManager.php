<?php

namespace App\Filament\Resources\Workshops\RelationManagers;

use App\Models\Enrollment;
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
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\EnrollStatus;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Validation\Rule;
use Filament\Actions\BulkAction;
use Illuminate\Support\Collection;
use Filament\Actions\Action;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Estudantes matriculados';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedAcademicCap;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->label('Estudante')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->columnSpan(3)
                    ->rules([
                        fn (Get $get, $record) =>
                            Rule::unique('enrollments', 'student_id')
                                ->where('enrollable_id', $this->getOwnerRecord()->id)
                                ->where('enrollable_type', get_class($this->getOwnerRecord()))
                                ->ignore($record?->id),
                    ])
                    ->validationMessages([
                        'unique' => 'Este(a) estudante já está matriculado nesta oficina.',
                    ]),
                DatePicker::make('start_date')
                    ->label('Data de matricula')
                    ->default(now())
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Data de fechamento'),
                Select::make('status')
                    ->options(
                        collect(EnrollStatus::cases())
                            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->native(false)
                    ->required(),
                Textarea::make('notes')
                    ->label('Observações')
                    ->columnSpan(3),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('student.name')
                    ->label('Student'),
                TextEntry::make('enrollable_type'),
                TextEntry::make('enrollable_id')
                    ->numeric(),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('notes')
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Enrollment $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('enrollment_id')
            ->columns([
                TextColumn::make('student.name')
                    ->label('Estudante')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Data de matrícula')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Data de fechamento')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->formatStateUsing(fn (?EnrollStatus $state) => $state?->label())
                    ->badge()
                    ->color(fn (?EnrollStatus $state): string => match ($state) {
                        EnrollStatus::CURSANDO => 'info',
                        EnrollStatus::APROVADO => 'success',
                        EnrollStatus::REPROVADO => 'danger',
                        EnrollStatus::ABANDONO => 'danger',
                        EnrollStatus::TRANCADO => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('notes')
                    ->label('Observações')
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
                    ->label('Nova matrícula')
                    ->icon('heroicon-o-plus')
                    ->modalHeading('Matricular estudante'),
                Action::make('printBlankAttendance')
                    ->label('Frequência em Branco')
                    ->hiddenLabel()
                    ->icon('heroicon-o-document')
                    ->modalWidth('xs')
                    ->color('gray')
                    ->schema([
                        Select::make('month')
                            ->label('Mês')
                            ->options([
                                1 => 'Janeiro',
                                2 => 'Fevereiro',
                                3 => 'Março',
                                4 => 'Abril',
                                5 => 'Maio',
                                6 => 'Junho',
                                7 => 'Julho',
                                8 => 'Agosto',
                                9 => 'Setembro',
                                10 => 'Outubro',
                                11 => 'Novembro',
                                12 => 'Dezembro',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $url = route('reports.workshop-attendance-blank', [
                            'workshop' => $this->ownerRecord->id,
                            'month' => $data['month'],
                        ]);

                        $this->js("window.open('{$url}', '_blank')");
                    }),
                    
                Action::make('attendanceReport')
                    ->label('Relatório de Frequência')
                    ->hiddenLabel()
                    ->icon('heroicon-o-document-text')
                    ->modalWidth('xs')
                    ->color('gray')
                    ->schema([
                        Select::make('month')
                            ->label('Mês')
                            ->options([
                                1 => 'Janeiro',
                                2 => 'Fevereiro',
                                3 => 'Março',
                                4 => 'Abril',
                                5 => 'Maio',
                                6 => 'Junho',
                                7 => 'Julho',
                                8 => 'Agosto',
                                9 => 'Setembro',
                                10 => 'Outubro',
                                11 => 'Novembro',
                                12 => 'Dezembro',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $url = route('reports.workshop-attendance', [
                            'workshop' => $this->ownerRecord->id,
                            'month' => $data['month'],
                        ]);

                        $this->js("window.open('{$url}', '_blank')");
                    }),

            ])
            ->recordActions([
                //ViewAction::make(),
                EditAction::make(),
                //DissociateAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('changeStatus')
                        ->label('Alterar status')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            Select::make('status')
                                ->label('Novo status')
                                ->options(
                                    collect(EnrollStatus::cases())
                                        ->mapWithKeys(fn ($case) => [
                                            $case->value => $case->label()
                                        ])
                                        ->toArray()
                                )
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->update([
                                    'status' => $data['status'],
                                ]);
                            });
                        })
                        ->requiresConfirmation(),                    
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
