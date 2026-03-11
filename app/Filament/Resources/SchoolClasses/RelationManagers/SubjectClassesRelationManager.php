<?php

namespace App\Filament\Resources\SchoolClasses\RelationManagers;

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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Actions\Action;
use App\Models\SubjectClass;

class SubjectClassesRelationManager extends RelationManager
{
    protected static string $relationship = 'subjectClasses';

    protected static ?string $title = 'Módulos cadastrados';

    protected static string|BackedEnum|null $icon = Heroicon::OutlinedRectangleStack;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->label('Módulo')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Professor(a)')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('subject.name')
                    ->label('Módulo')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Professor(a)')
                    ->sortable(),
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
                    ->label('Novo módulo')
                    ->modalHeading('Cadastrar módulo'),
                //AssociateAction::make(),
            ])
            ->recordActions([
                Action::make('blackAttendance')
                    ->label('Frequência em branco')
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
                    ->action(function (SubjectClass $record, array $data) {
                        $url = route('reports.attendance-blank', [
                            'subjectClass' => $record->id,
                            'month' => $data['month'],
                        ]);

                        $this->js("window.open('{$url}', '_blank')");
                    }),

                Action::make('attendance')
                    ->label('Frequência')
                    ->icon('heroicon-o-document-text')
                    ->modalWidth('xs')
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
                    ->action(function (SubjectClass $record, array $data) {
                        $url = route('reports.attendance', [
                            'subjectClass' => $record->id,
                            'month' => $data['month'],
                        ]);

                        $this->js("window.open('{$url}', '_blank')");
                    }),






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
