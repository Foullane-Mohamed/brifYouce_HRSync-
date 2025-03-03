<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CareerEvent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'employee_id', 'type', 'date', 'title', 'description',
        'previous_salary', 'new_salary', 'previous_position', 
        'new_position', 'created_by'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('certificates');
        $this->addMediaCollection('documents');
    }
}