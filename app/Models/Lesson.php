<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'subject_class_id',
        'date',
        'color',
        'starts_at',
        'ends_at'
    ];

    public function subjectClass(): BelongsTo
    {
        return $this->belongsTo( SubjectClass::class );
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
