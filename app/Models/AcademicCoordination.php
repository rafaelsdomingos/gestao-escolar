<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AcademicCoordination extends Model
{
    /** @use HasFactory<\Database\Factories\AcademicCoordinationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'coordinator',
        'phone',
        'email',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }


}
