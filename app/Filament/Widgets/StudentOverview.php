<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\SchoolClass;
use App\Models\Workshop;
use App\Models\AcademicYear;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class StudentOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $academicYearId = $this->pageFilters['academic_year_id'] ?? AcademicYear::where('is_current', true)->value('id');

        $academicYear = AcademicYear::where('id', $academicYearId)->value('year');

        $courseEnrollments = Enrollment::where('enrollable_type', SchoolClass::class)
            ->whereHasMorph('enrollable', [SchoolClass::class],
                function ($query) use ($academicYearId) {
                    $query->where('academic_year_id', $academicYearId);
                })
                ->count();

        
        $workshopEnrollments = Enrollment::where('enrollable_type', Workshop::class)
            ->whereHasMorph('enrollable', [Workshop::class],
                function ($query) use ($academicYearId) {
                    $query->where('academic_year_id', $academicYearId);
                }
            )
            ->count();

        if (!$academicYearId) 
        {
            return [

            ];
        }
        else
        {
            return [
                Stat::make('Ano Letivo', $academicYear),
                Stat::make('Matrículas em Cursos', $courseEnrollments),
                Stat::make('Matrículas em Oficinas', $workshopEnrollments),
            ];
        }

        
    }
}
