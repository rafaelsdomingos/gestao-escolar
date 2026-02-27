<?php

namespace App\Filament\Resources\WorkshopLessons\Pages;

use App\Filament\Resources\WorkshopLessons\WorkshopLessonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkshopLesson extends ViewRecord
{
    protected static string $resource = WorkshopLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //EditAction::make(),
        ];
    }
}
