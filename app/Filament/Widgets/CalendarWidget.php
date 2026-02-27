<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Lesson;
use App\Filament\Resources\Lessons\LessonResource;

class CalendarWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Lesson::query()
            ->where('starts_at', '>=', $fetchInfo['start'])
            ->where('ends_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Lesson $event) => [
                    'title' => $event->subjectClass->subject->name,
                    'start' => $event->starts_at,
                    'color' => $event->color,
                    'end' => $event->ends_at,
                    'url' => LessonResource::getUrl(name: 'view', parameters: ['record' => $event]),
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
