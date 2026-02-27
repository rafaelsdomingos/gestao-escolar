<?php

namespace App\Filament\Resources\Workshops\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Carbon\Carbon;

class WorkshopLessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'workshopLessons';

    protected static ?string $title = 'Datas das aulas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Data da aula')
                    ->required(),
                ColorPicker::make('color')
                    ->label('Cor do marcador'),
                DateTimePicker::make('starts_at')
                    ->label('Início')
                    ->seconds(false)
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->label('Final')
                    ->seconds(false)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('workshop_lesson_id')
            ->columns([
                TextColumn::make('date')
                    ->label('Data da aula')
                    ->date('d/m/Y')
                    ->searchable()
                    ->sortable(),
                ColorColumn::make('color')
                    ->label('Cor do marcador'),
                TextColumn::make('starts_at')
                    ->time()
                    ->label('Início'),
                TextColumn::make('ends_at')
                    ->time()
                    ->label('Final'),
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
                //    ->label('Cadastrar aula')
                //    ->modalHeading('Cadastrar dia aula'),
                //AssociateAction::make(),
                Action::make('generateLessons')
                    ->label('Gerar aulas')
                    ->icon('heroicon-o-calendar-days')
                    ->schema([
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

                        TimePicker::make('starts_at')
                            ->label('Hora início')
                            ->seconds(false)
                            ->required(),

                        TimePicker::make('ends_at')
                            ->label('Hora fim')
                            ->seconds(false)
                            ->required(),
                    ])

                    ->action(function (array $data, RelationManager $livewire) {

                        $workshop = $livewire->getOwnerRecord();

                        $periodStart = Carbon::parse($workshop->start_date);
                        $periodEnd   = Carbon::parse($workshop->end_date);

                        $created = 0;

                        while ($periodStart->lte($periodEnd)) {

                            if (in_array($periodStart->isoWeekday(), $data['week_days'])) {

                                $startsAt = $periodStart->copy()
                                    ->setTimeFromTimeString($data['starts_at']);

                                $endsAt = $periodStart->copy()
                                    ->setTimeFromTimeString($data['ends_at']);

                                // Validação de horário
                                if ($endsAt->lte($startsAt)) {
                                    \Filament\Notifications\Notification::make()
                                        ->title('Horário inválido')
                                        ->body('O horário de término deve ser maior que o horário de início.')
                                        ->danger()
                                        ->send();

                                    return;
                                }

                                $exists = $workshop->workshopLessons()
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

                                    $workshop->workshopLessons()->create([
                                        'date' => $periodStart->toDateString(),
                                        'starts_at' => $startsAt,
                                        'ends_at' => $endsAt,
                                        'color' => '#3b82f6',
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
                EditAction::make()
                    ->label('Editar')
                    ->modalHeading('Editar aula'),
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
