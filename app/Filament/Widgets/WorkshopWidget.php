<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\WorkshopLesson;
use App\Filament\Resources\WorkshopLessons\WorkshopLessonResource;

class WorkshopWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return WorkshopLesson::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (WorkshopLesson $event) => [
                    'title' => $event->workshop->name,
                    'start' => $event->starts_at,
                    'color' => $event->color,
                    'end' => $event->ends_at,
                    'url' => WorkshopLessonResource::getUrl(name: 'view', parameters: ['record' => $event]),
                    'shouldOpenUrlInNewTab' => false
                ]
            )
            ->toArray();       
    }
    
    protected function headerActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }

    public function config(): array
    {
        return [
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,dayGridWeek,dayGridDay',
            ],
        ];
    }
}
