<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkshopLesson extends Model
{
    protected $fillable = [
        'workshop_id',
        'date',
        'color',
        'starts_at',
        'ends_at'
    ];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo( Workshop::class );
    }

    public function workshopAttendances(): HasMany
    {
        return $this->hasMany(WorkshopAttendance::class);
    }
}
