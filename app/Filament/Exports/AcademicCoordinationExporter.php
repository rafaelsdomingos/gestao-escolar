<?php

namespace App\Filament\Exports;

use App\Models\AcademicCoordination;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class AcademicCoordinationExporter extends Exporter
{
    protected static ?string $model = AcademicCoordination::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Nome'),
            ExportColumn::make('code')->label('Sigla'),
            ExportColumn::make('coordinator')->label('Coordenador(a)'),
            ExportColumn::make('phone')->label('Fone'),
            ExportColumn::make('email')->label('E-mail'),
            ExportColumn::make('created_at')->label('Data de criação'),
            ExportColumn::make('updated_at')->label('Data de atualização'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your academic coordination export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
