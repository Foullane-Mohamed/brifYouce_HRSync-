<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hierarchie extends Model
{
    use HasFactory;

    protected $fillable = ['employe_id', 'manager_id', 'position', 'date_ajout'];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function manager()
    {
        return $this->belongsTo(Employe::class, 'manager_id');
    }
}
