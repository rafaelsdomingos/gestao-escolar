<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'relationship',
        'phone'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}