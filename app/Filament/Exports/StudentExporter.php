<?php

namespace App\Filament\Exports;

use App\Models\Student;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class StudentExporter extends Exporter
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nome'),
            ExportColumn::make('social_name')
                ->label('Nome social'),
            ExportColumn::make('nationality')
                ->label('Nacionalidade'),
            ExportColumn::make('birthplace')
                ->label('Naturalidade'),
            ExportColumn::make('birthdate')
                ->label('Data de nascimento'),
            ExportColumn::make('gender')
                ->label('Gênero'),
            ExportColumn::make('race_color')
                ->label('Raça/Cor'),
            ExportColumn::make('address')
                ->label('Endereço'),
            ExportColumn::make('neighborhood')
                ->label('Bairro'),
            ExportColumn::make('city')
                ->label('Cidade'),
            ExportColumn::make('uf')
                ->label('UF'),
            ExportColumn::make('zip_code')
                ->label('CEP'),
            ExportColumn::make('ser')
                ->label('Regional'),
            ExportColumn::make('cel_number')
                ->label('Celular'),
            ExportColumn::make('email')
                ->label('E-mail'),
            ExportColumn::make('education_level')
                ->label('Escolaridade'),
            ExportColumn::make('grade')
                ->label('Gênero'),
            ExportColumn::make('shift')
                ->label('Turno'),
            ExportColumn::make('institution')
                ->label('Instituição'),
            ExportColumn::make('institution_type')
                ->label('Tipo de instituição'),
            ExportColumn::make('cpf')
                ->label('CPF'),
            ExportColumn::make('rg')
                ->label('RG'),
            ExportColumn::make('rg_authority')
                ->label('Órgão Emissor'),
            ExportColumn::make('rg_state')
                ->label('UF'),
            ExportColumn::make('mother_name')
                ->label('Nome da mãe'),
            ExportColumn::make('father_name')
                ->label('Nome do pai'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your student export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
