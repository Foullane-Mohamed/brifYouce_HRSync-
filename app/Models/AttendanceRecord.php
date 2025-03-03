<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'clock_in',
        'clock_out',
        'break_start',
        'break_end',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
        'break_start' => 'datetime',
        'break_end' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
