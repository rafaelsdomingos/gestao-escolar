<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopAttendance extends Model
{
    protected $fillable = [
        'workshop_lesson_id',
        'student_id',
        'is_present',
    ];

    protected $casts = [
        'is_present' => 'boolean',
    ];

    public function workshopLesson(): BelongsTo
    {
        return $this->belongsTo(WorkshopLesson::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }   
}
