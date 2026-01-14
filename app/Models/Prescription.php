<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Prescription extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'examination_id',
        'notes',
        'status',
        'total_price',
        'pharmacist_id',
        'processed_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function doctor()
    {
        return $this->hasOneThrough(User::class, Examination::class, 'id', 'id', 'examination_id', 'doctor_id');
    }

    public function pharmacist()
    {
        return $this->belongsTo(User::class, 'pharmacist_id');
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'IDR ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getFormattedProcessedAtAttribute()
    {
        return $this->processed_at ? $this->processed_at->format('d F Y H:i') : null;
    }

    public function canBeEdited()
    {
        return $this->status === 'draft' || $this->status === 'waiting';
    }

    public function isProcessed()
    {
        return $this->status === 'processed' || $this->status === 'completed';
    }
}
