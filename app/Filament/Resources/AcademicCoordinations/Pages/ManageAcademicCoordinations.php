<?php

namespace App\Filament\Resources\AcademicCoordinations\Pages;

use App\Filament\Resources\AcademicCoordinations\AcademicCoordinationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAcademicCoordinations extends ManageRecords
{
    protected static string $resource = AcademicCoordinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
