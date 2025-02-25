<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'email', 'telephone', 'date_naissance', 'adresse', 'date_recrutement', 'type_contrat', 'salaire', 'statut', 'departement_id'];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
