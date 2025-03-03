<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'employee_id',
        'phone_number',
        'address',
        'position',
        'department',
        'hire_date',
        'salary',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'hire_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function performanceReviews(): HasMany
    {
        return $this->hasMany(PerformanceReview::class);
    }

    public function isAdmin(): bool
    {
        return $this->role && $this->role->slug === 'admin';
    }

    public function isHR(): bool
    {
        return $this->role && $this->role->slug === 'hr';
    }

    public function isEmployee(): bool
    {
        return $this->role && $this->role->slug === 'employee';
    }
}