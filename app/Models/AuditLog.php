<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'table_name',
        'old_values',
        'new_values',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedOldValuesAttribute()
    {
        return $this->old_values ? json_encode($this->old_values, JSON_PRETTY_PRINT) : null;
    }

    public function getFormattedNewValuesAttribute()
    {
        return $this->new_values ? json_encode($this->new_values, JSON_PRETTY_PRINT) : null;
    }
}
