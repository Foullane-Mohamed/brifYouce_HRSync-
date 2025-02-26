<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerDevelopment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type',
        'previous_value',
        'new_value',
        'date',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
