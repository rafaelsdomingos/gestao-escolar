<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\EnrollStatus;

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
}
