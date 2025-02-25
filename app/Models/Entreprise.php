<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
  use HasFactory;

  protected $fillable = ['nom', 'secteur', 'adresse', 'logo', 'email', 'telephone', 'date_inscription'];

  public function utilisateurs()
  {
      return $this->hasMany(User::class);
  }

  public function employes()
  {
      return $this->hasManyThrough(Employe::class, User::class);
  }
}