<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubjectClass extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_class_id',
        'subject_id',
        'user_id',
    ];

    public function schoolClass(): BelongsTo 
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function subject(): BelongsTo 
    {
        return $this->belongsTo(Subject::class);
    }

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany( Lesson::class );
    }


}
