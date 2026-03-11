<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\WorkshopLesson;
use App\Models\Workshop;
use App\Filament\Resources\WorkshopLessons\WorkshopLessonResource;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Facades\Filament;

class WorkshopWidget extends FullCalendarWidget
{
    use HasWidgetShield;

    public function fetchEvents(array $fetchInfo): array
    {
        if (Filament::auth()->user()?->hasRole('Professor'))
        {
            return WorkshopLesson::query()
                ->whereRelation('subjectClass', 'user_id', Filament::auth()->id())
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
        elseif (Filament::auth()->user()->hasRole('Coordenação'))
        {
            $coordinationIds = Filament::auth()->user()
                ->academicCoordinations()
                ->pluck('academic_coordination_id');

            return WorkshopLesson::query()
                ->with('workshop')
                ->whereHas('workshop', function ($query) use ($coordinationIds) {
                    $query->whereIn('academic_coordination_id', $coordinationIds);
                })
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
        else{
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
