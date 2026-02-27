<?php

namespace App\Filament\Resources\WorkshopLessons\Pages;

use App\Filament\Resources\WorkshopLessons\WorkshopLessonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkshopLessons extends ListRecords
{
    protected static string $resource = WorkshopLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
