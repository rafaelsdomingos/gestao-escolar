<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RaceColor;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'social_name',
        'nationality',
        'birthplace',
        'birthdate',
        'gender',
        'race_color',
    ];

    protected $casts = [
        'race_color' => RaceColor::class,
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function workshopAttendances(): HasMany
    {
        return $this->hasMany(WorkshopAttendance::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
