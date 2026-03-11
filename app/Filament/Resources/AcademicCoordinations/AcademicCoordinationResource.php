<?php

namespace App\Filament\Resources\AcademicCoordinations;

use App\Filament\Resources\AcademicCoordinations\Pages\ManageAcademicCoordinations;
use App\Models\AcademicCoordination;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Exports\AcademicCoordinationExporter;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\Enums\ExportFormat;

class AcademicCoordinationResource extends Resource
{
    protected static ?string $model = AcademicCoordination::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Coordenação';

    protected static ?string $pluralModelLabel = 'Coordenações';

    protected static string | UnitEnum | null $navigationGroup = 'Escolas';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->unique()
                    ->required(),
                TextInput::make('code')
                    ->label('Sigla')
                    ->unique()
                    ->required(),
                TextInput::make('coordinator')
                    ->label('Coordenador(a)')
                    ->required(),
                TextInput::make('phone')
                    ->label('Fone')
                    ->mask('(99) 99999-9999')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email')
                    ->email(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Sigla')
                    ->searchable(),
                TextColumn::make('coordinator')
                    ->label('Coordenador(a)')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Contato')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
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
                TrashedFilter::make(),
            ])
            ->headerActions([
                // ExportAction::make()
                //     ->exporter(AcademicCoordinationExporter::class)
                //     ->label('Exportar Planilha')
                //     ->icon('heroicon-o-table-cells')
                //     ->enableVisibleTableColumnsByDefault()
                //     ->fileName(fn (Export $export): string => "coordenações-{$export->getKey()}")
                //     ->formats([
                //         ExportFormat::Xlsx,
                //         ExportFormat::Csv,
                    // ])
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
                ExportBulkAction::make()
                    ->exporter(AcademicCoordinationExporter::class)
                    ->label('Exportar dados selecionados')
                    ->icon('heroicon-o-table-cells')
                    ->enableVisibleTableColumnsByDefault()
                    ->fileName(fn (Export $export): string => "coordenações-{$export->getKey()}")
                    ->formats([
                        ExportFormat::Xlsx,
                        ExportFormat::Csv,
                    ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAcademicCoordinations::route('/'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
