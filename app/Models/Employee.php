<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Employee extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id', 'department_id', 'company_id', 'birth_date', 'hire_date',
        'position', 'contract_type', 'salary', 'status', 'manager_id', 'address'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function careerEvents()
    {
        return $this->hasMany(CareerEvent::class);
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('contracts');
        $this->addMediaCollection('payslips');
        $this->addMediaCollection('documents');
    }
}