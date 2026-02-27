<?php

namespace App\Filament\Resources\SchoolClasses\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Actions\Action;
use Carbon\Carbon;
use App\Models\SubjectClass;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    protected static ?string $title = 'Datas das aulas';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedCalendarDateRange;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subject_class_id')
                    ->relationship(
                        name: 'subjectClass',
                        titleAttribute: 'id',
                        modifyQueryUsing: function ($query) {

                            $query->where('subject_classes.school_class_id', $this->getOwnerRecord()->id)
                                ->join('subjects', 'subjects.id', '=', 'subject_classes.subject_id')
                                ->select('subject_classes.id', 'subjects.name')
                                ->orderBy('subjects.name');
                        }
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('color'),
                TimePicker::make('starts_at')
                    ->required(),
                TimePicker::make('ends_at')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lesson_id')
            ->columns([
                TextColumn::make('subjectClass.subject.name')
                    ->label('Módulo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->date('d/m/Y')
                    ->label('Data')
                    ->sortable(),
                TextColumn::make('color')
                    ->label('Dia da semana')
                    ->formatStateUsing(fn ($record) =>
                        \Carbon\Carbon::parse($record->date)->translatedFormat('l')
                    )
                    ->sortable(query: function ($query, $direction) {
                        $query->orderBy('date', $direction);
                    })
                    ->searchable(),
                TextColumn::make('starts_at')
                    ->label('Início')
                    ->time()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->label('Término')
                    ->time()
                    ->sortable(),
                TextColumn::make('subjectClass.user.name')
                    ->label('Professor(a)')
                    ->searchable()
                    ->sortable(),
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
                //
            ])
            ->headerActions([
                //CreateAction::make()
                //   ->label('Cadastrar aulas')
                //   ->icon('heroicon-o-calendar-days')
                //   ->modalHeading('Cadastrar aulas'),
                Action::make('generateLessons')
                    ->label('Gerar aulas')
                    ->schema([
                        Select::make('subject_class_id')
                            ->label('Módulo')
                            ->relationship(
                                name: 'subjectClass',
                                titleAttribute: 'id',
                                modifyQueryUsing: function ($query) {
                                    $query->where('subject_classes.school_class_id', $this->getOwnerRecord()->id)
                                        ->join('subjects', 'subjects.id', '=', 'subject_classes.subject_id')
                                        ->select('subject_classes.id', 'subjects.name')
                                        ->orderBy('subjects.name');
                                }
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                            ->required(),

                        CheckboxList::make('week_days')
                            ->label('Dias da semana')
                            ->options([
                                1 => 'Segunda',
                                2 => 'Terça',
                                3 => 'Quarta',
                                4 => 'Quinta',
                                5 => 'Sexta',
                                6 => 'Sábado',
                            ])
                            ->columns(3)
                            ->required(),

                        ColorPicker::make('color')
                            ->label('Cor do marcador')
                            ->required(),

                        TimePicker::make('starts_at')
                            ->label('Início')
                            ->required(),

                        TimePicker::make('ends_at')
                            ->label('Término')
                            ->required(),
                    ])

                    ->action(function (array $data, RelationManager $livewire) {

                        $schoolClass = $livewire->getOwnerRecord();

                        $subject = SubjectClass::where('id', $data['subject_class_id'])
                            ->where('school_class_id', $schoolClass->id)
                            ->firstOrFail();

                        $periodStart = Carbon::parse($schoolClass->start_date);
                        $periodEnd   = Carbon::parse($schoolClass->end_date);

                        $created = 0;

                        while ($periodStart->lte($periodEnd)) {

                            if (in_array($periodStart->isoWeekday(), $data['week_days'])) {

                                $startsAt = $periodStart->copy()
                                    ->setTimeFromTimeString($data['starts_at']);

                                $endsAt = $periodStart->copy()
                                    ->setTimeFromTimeString($data['ends_at']);

                                if ($endsAt->lte($startsAt)) {
                                    \Filament\Notifications\Notification::make()
                                        ->title('Horário inválido')
                                        ->body('O horário de término deve ser maior que o horário de início.')
                                        ->danger()
                                        ->send();

                                    return;
                                }

                                $exists = $subject->lessons()
                                    ->where(function ($query) use ($startsAt, $endsAt) {
                                        $query->whereBetween('starts_at', [$startsAt, $endsAt])
                                            ->orWhereBetween('ends_at', [$startsAt, $endsAt])
                                            ->orWhere(function ($q) use ($startsAt, $endsAt) {
                                                $q->where('starts_at', '<=', $startsAt)
                                                    ->where('ends_at', '>=', $endsAt);
                                            });
                                    })
                                    ->exists();

                                if (! $exists) {

                                    $subject->lessons()->create([
                                        'date' => $periodStart->toDateString(),
                                        'starts_at' => $startsAt,
                                        'ends_at' => $endsAt,
                                        'color' => $data['color'],
                                    ]);

                                    $created++;
                                }
                            }

                            $periodStart->addDay();
                        }

                        if ($created === 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Nenhuma aula foi criada')
                                ->body('Já existem aulas cadastradas nesse período.')
                                ->warning()
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Aulas geradas com sucesso')
                                ->body("Foram criadas {$created} aulas.")
                                ->success()
                                ->send();
                        }
                    })

                    ->modalHeading('Gerar aulas automaticamente')
                    ->modalSubmitActionLabel('Gerar')
                    ->requiresConfirmation(),
               

            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
