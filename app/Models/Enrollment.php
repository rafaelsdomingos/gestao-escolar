<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\EnrollStatus;
use Illuminate\Validation\ValidationException;
use App\Models\SchoolClass;
use Filament\Notifications\Notification;

class Enrollment extends Model
{
    use softDeletes;
    
    protected $fillable = [
        'student_id',
        'enrollable_id',
        'enrollable_type',
        'start_date',
        'end_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'status' => EnrollStatus::class,
    ];

    public function enrollable(): MorphTo
    {
        return $this->morphTo();
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    protected static function booted()
    {
        static::creating(function ($enrollment) {

            if ($enrollment->enrollable_type !== SchoolClass::class) {
                return;
            }

            $schoolClass = SchoolClass::find($enrollment->enrollable_id);

            $courseId = $schoolClass->course_id;
            $academicYearId = $schoolClass->academic_year_id;

            $exists = self::where('student_id', $enrollment->student_id)
                ->where('enrollable_type', SchoolClass::class)
                ->whereHasMorph(
                    'enrollable',
                    SchoolClass::class,
                    fn ($query) => $query
                        ->where('course_id', $courseId)
                        ->where('academic_year_id', $academicYearId)
                )
                ->exists();

            if ($exists) {
                Notification::make()
                    ->title('Matrícula não permitida')
                    ->body('Este aluno já está matriculado em outra turma deste curso neste ano letivo.')
                    ->danger()
                    ->send();
                throw ValidationException::withMessages([
                    'student_id' => 'Este aluno já está matriculado em outra turma deste curso neste ano letivo.'
                ]);
            }
        });
    }
}
