<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'course_id',
    ];

    public function course(): BelongsTo 
    {
        return $this->belongsTo(Course::class);
    }
}
