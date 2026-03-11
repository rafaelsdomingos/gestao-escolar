<?php

namespace App\Models;

use App\Enums\FederalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RaceColor;
use App\Enums\Gender;
use App\Enums\Ser;
use App\Enums\EducationLevel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    // protected static function booted()
    // {
    //     static::creating(function ($student) {
    //         $student->registration_number = self::generateRegistrationNumber();
    //     });
    // }

    // public static function generateRegistrationNumber()
    // {
    //     $year = date('Y');

    //     $last = self::where('registration_number', 'like', $year.'%')
    //         ->orderBy('registration_number', 'desc')
    //         ->first();

    //     $sequence = $last
    //         ? intval(substr($last->registration_number, 4)) + 1
    //         : 1;

    //     return $year . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    // }

    protected $fillable = [
        'name',
        'social_name',
        'nationality',
        'photo',
        'birthplace',
        'birthdate',
        'gender',
        'race_color',
        'address',
        'neighborhood',
        'city',
        'uf',
        'zip_code',
        'ser',
        'cel_number',
        'email',
        'education_level',
        'grade',
        'shift',
        'institution',
        'institution_type',
        'cpf',
        'rg',
        'rg_authority',
        'rg_state',
        'mother_name',
        'mother_rg',
        'mother_rg_authority',
        'mother_rg_state',
        'father_name',
        'father_rg',
        'father_rg_authority',
        'father_rg_state'
    ];
    // protected static function booted()
    // {
    //     static::creating(function ($student) {
    //         $student->registration_number = self::generateRegistrationNumber();
    //     });
    // }

    // public static function generateRegistrationNumber()
    // {
    //     $year = date('Y');

    //     $last = self::where('registration_number', 'like', $year.'%')
    //         ->orderBy('registration_number', 'desc')
    //         ->first();

    //     $sequence = $last
    //         ? intval(substr($last->registration_number, 4)) + 1
    //         : 1;

    //     return $year . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    // }
    protected $casts = [
        'race_color' => RaceColor::class,
        'gender' => Gender::class,
        'ser' => Ser::class,
        'uf' => FederalUnit::class,
        'education_level' => EducationLevel::class
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

    public function healthConditions(): HasMany
    {
        return $this->hasMany(StudentHealthCondition::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
