<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Examination extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'examination_date',
        'height',
        'weight',
        'systolic',
        'diastolic',
        'heart_rate',
        'respiration_rate',
        'temperature',
        'doctor_notes',
        'external_file_path',
        'status',
    ];

    protected $casts = [
        'examination_date' => 'datetime',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'temperature' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function getBmiAttribute()
    {
        if ($this->height && $this->weight) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 1);
        }
        return null;
    }

    public function getBloodPressureAttribute()
    {
        if ($this->systolic && $this->diastolic) {
            return "{$this->systolic}/{$this->diastolic}";
        }
        return null;
    }

    public function getFormattedExaminationDateAttribute()
    {
        return $this->examination_date ? $this->examination_date->format('d F Y H:i') : null;
    }
}
