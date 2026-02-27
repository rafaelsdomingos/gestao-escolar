<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\CourseModality;

class Course extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'academic_coordination_id',
        'name',
        'modality',
        'description'
    ];

    protected $casts = [
        'modality' => CourseModality::class,
    ];

    public function academicCoordination(): BelongsTo
    {
        return $this->belongsTo(AcademicCoordination::class);
    }

    public function schoolClasses(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }
}
