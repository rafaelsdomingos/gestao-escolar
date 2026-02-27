<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Workshop extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'academic_coordination_id',
        'academic_year_id',
        'user_id',
        'name',
        'start_date',
        'end_date',
        'shift'
    ];

    public function academicCoordination(): BelongsTo
    {
        return $this->belongsTo(AcademicCoordination::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function enrollments(): MorphMany
    {
        return $this->morphMany(Enrollment::class, 'enrollable');
    }

    public function workshopLessons(): HasMany
    {
        return $this->hasMany( WorkshopLesson::class );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
