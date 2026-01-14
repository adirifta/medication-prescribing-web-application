<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isPharmacist(): bool
    {
        return $this->role === 'pharmacist';
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class, 'doctor_id');
    }

    public function processedPrescriptions()
    {
        return $this->hasMany(Prescription::class, 'pharmacist_id');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => 'bg-purple-100 text-purple-800',
            'doctor' => 'bg-blue-100 text-blue-800',
            'pharmacist' => 'bg-green-100 text-green-800',
        ];

        return isset($badges[$this->role]) ? $badges[$this->role] : 'bg-gray-100 text-gray-800';
    }

    public function getFormattedRoleAttribute()
    {
        return ucfirst($this->role);
    }
}
