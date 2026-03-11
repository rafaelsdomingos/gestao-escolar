<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Workshop;
use App\Models\SubjectClass;
use App\Models\WorkshopAttendance;

class PdfController extends Controller
{

    public function blankWorkshopAttendance(Workshop $workshop, int $month)
    {
        $year = $workshop->academicYear->year;

        $lessons = $workshop->workshopLessons()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        $students = $workshop->enrollments()
            ->with('student')
            ->get()
            ->map(fn ($enrollment) => $enrollment->student)
            ->sortBy('name');

        $pdf = Pdf::loadView('reports.workshop-attendance-blank', [
            'workshop' => $workshop,
            'students' => $students,
            'lessons' => $lessons,
            'month' => $month,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('ficha-frequencia.pdf');
    }


    public function workshopAttendance(Workshop $workshop, int $month)
    {
        $year = $workshop->academicYear->year;

        $lessons = $workshop->workshopLessons()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with(['workshopAttendances'])
            ->orderBy('date')
            ->get();

        $students = $workshop->enrollments()
            ->with('student')
            ->get()
            ->map(fn ($enrollment) => $enrollment->student)
            ->sortBy('name')
            ->values();

        $attendanceMap = [];

        foreach ($lessons as $lesson) {
            foreach ($lesson->workshopAttendances as $attendance) {
                $attendanceMap[$attendance->student_id][$lesson->id] = $attendance->is_present;
            }
        }

        $statistics = [];

        $totalLessons = $lessons->count();

        foreach ($students as $student) {

            $studentAttendances = collect($attendanceMap[$student->id] ?? []);

            $totalPresent = $studentAttendances
                ->filter(fn ($value) => $value === true)
                ->count();

            $totalAbsent = $studentAttendances
                ->filter(fn ($value) => $value === false)
                ->count();

            $percentage = $totalLessons > 0
                ? round(($totalPresent / $totalLessons) * 100)
                : 0;

            $statistics[$student->id] = [
                'present' => $totalPresent,
                'absent' => $totalAbsent,
                'percentage' => $percentage,
            ];
        }

        $pdf = Pdf::loadView('reports.workshop-attendance', [
            'workshop' => $workshop,
            'students' => $students,
            'lessons' => $lessons,
            'attendanceMap' => $attendanceMap,
            'statistics' => $statistics,
            'month' => $month,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('ficha-frequencia.pdf');
    }

    public function blankAttendance(SubjectClass $subjectClass, int $month)
    {
        $year = $subjectClass->schoolClass->academicYear->year;

        $lessons = $subjectClass->lessons()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();

        $students = $subjectClass->schoolClass->enrollments()
            ->with('student')
            ->get()
            ->map(fn ($enrollment) => $enrollment->student)
            ->sortBy('name');

        $pdf = Pdf::loadView('reports.attendance-blank', [
            'subjectClass' => $subjectClass,
            'students' => $students,
            'lessons' => $lessons,
            'month' => $month,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('ficha-frequencia.pdf');
    }

    public function attendance(SubjectClass $subjectClass, int $month)
    {
        $year = $subjectClass->schoolClass->academicYear->year;

        $lessons = $subjectClass->lessons()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with(['attendances'])
            ->orderBy('date')
            ->get();

        $students = $subjectClass->schoolClass->enrollments()
            ->with('student')
            ->get()
            ->map(fn ($enrollment) => $enrollment->student)
            ->sortBy('name')
            ->values();

        $attendanceMap = [];

        foreach ($lessons as $lesson) {
            foreach ($lesson->attendances as $attendance) {
                $attendanceMap[$attendance->student_id][$lesson->id] = $attendance->is_present;
            }
        }

        $statistics = [];

        $totalLessons = $lessons->count();

        foreach ($students as $student) {

            $studentAttendances = collect($attendanceMap[$student->id] ?? []);

            $totalPresent = $studentAttendances
                ->filter(fn ($value) => $value === true)
                ->count();

            $totalAbsent = $studentAttendances
                ->filter(fn ($value) => $value === false)
                ->count();

            $percentage = $totalLessons > 0
                ? round(($totalPresent / $totalLessons) * 100)
                : 0;

            $statistics[$student->id] = [
                'present' => $totalPresent,
                'absent' => $totalAbsent,
                'percentage' => $percentage,
            ];
        }

        $pdf = Pdf::loadView('reports.attendance', [
            'subjectClass' => $subjectClass,
            'students' => $students,
            'lessons' => $lessons,
            'attendanceMap' => $attendanceMap,
            'statistics' => $statistics,
            'month' => $month,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('ficha-frequencia.pdf');
    }
}
