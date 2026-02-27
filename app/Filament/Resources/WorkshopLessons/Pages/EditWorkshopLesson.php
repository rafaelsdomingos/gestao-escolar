<?php

namespace App\Filament\Resources\WorkshopLessons\Pages;

use App\Filament\Resources\WorkshopLessons\WorkshopLessonResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkshopLesson extends EditRecord
{
    protected static string $resource = WorkshopLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
