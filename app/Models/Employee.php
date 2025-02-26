<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'manager_id',
        'position',
        'hire_date',
        'birth_date',
        'address',
        'salary',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function careerDevelopments()
    {
        return $this->hasMany(CareerDevelopment::class);
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'employee_training')
            ->withPivot('status')
            ->withTimestamps();
    }
}