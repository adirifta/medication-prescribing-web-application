<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class PrescriptionItem extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'medicine_name',
        'quantity',
        'unit_price',
        'subtotal',
        'instructions',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function getFormattedUnitPriceAttribute()
    {
        return 'IDR ' . number_format($this->unit_price, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'IDR ' . number_format($this->subtotal, 0, ',', '.');
    }
}
