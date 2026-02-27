<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SchoolClass extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'academic_year_id',
        'name',
        'shift',
        'start_date',
        'end_date'
    ];

    public function course(): BelongsTo 
    {
        return $this->belongsTo(Course::class);
    }

    public function academicYear(): BelongsTo 
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function enrollments(): MorphMany
    {
        return $this->morphMany(Enrollment::class, 'enrollable');
    }

    public function subjectClasses(): HasMany
    {
        return $this->hasMany(SubjectClass::class);
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, SubjectClass::class);
    }
}
