<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentHealthCondition extends Model
{
    protected $fillable = [
        'type',
        'description',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
