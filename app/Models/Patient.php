<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Patient extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'medical_record_number',
        'name',
        'date_of_birth',
        'gender',
        'address',
        'phone',
        'email',
        'blood_type',
        'allergies',
        'chronic_conditions',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? now()->diffInYears($this->date_of_birth) : null;
    }

    public function getFormattedDateOfBirthAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->format('d F Y') : null;
    }
}
