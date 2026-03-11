<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Lesson;
use App\Models\SchoolClass;
use App\Filament\Resources\Lessons\LessonResource;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Facades\Filament;

class CalendarWidget extends FullCalendarWidget
{
    use HasWidgetShield;

    public function fetchEvents(array $fetchInfo): array
    {   
        if (Filament::auth()->user()?->hasRole('Professor'))
        {
            return Lesson::query()
                ->whereRelation('subjectClass', 'user_id', Filament::auth()->id())
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
        elseif (Filament::auth()->user()->hasRole('Coordenação'))
        {
            $user = Filament::auth()->user();

            $coords = $user->academicCoordinations()->pluck('academic_coordination_id');

            $schoolClasses = SchoolClass::whereHas('course', function ($query) use ($coords){
                $query->whereIn('academic_coordination_id', $coords);
            })->pluck('id');

            return Lesson::query()
                ->whereHas('subjectClass', function ($query) use ($schoolClasses) {
                        $query->whereIn('school_class_id', $schoolClasses);
                    })
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
        else
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
