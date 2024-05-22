<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adherant extends Model
{
    use HasFactory;

  protected $fillable = [
    'prenom','nom', 'nom_entreprise', 'telephone','email', 'adresse', 'population','agence_id'
  ];

  public function agence(): BelongsTo
  {
    return $this->belongsTo(Agence::class);

  }
}

