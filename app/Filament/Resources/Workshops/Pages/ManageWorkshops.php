<?php

namespace App\Filament\Resources\Workshops\Pages;

use App\Filament\Resources\Workshops\WorkshopResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageWorkshops extends ManageRecords
{
    protected static string $resource = WorkshopResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
