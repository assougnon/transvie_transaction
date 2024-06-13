<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Transaction extends Model
{
    use HasFactory;
  protected $fillable = [
    'numero',
    'montant',
    'delai',
    'type',
    'statut',
    'adherant_prenom',
    'adherant_nom',
    'adherant_entreprise',
    'adherant_telephone',
    'adherant_adresse',
    'adherant_population',
    'note',
    'user_id',
    'remise_id',
    'adherant_id',
    'banque_id',
    'agence_id',
    'pays_id'
  ];


  public function creerle()
  {

      return $this->created_at->translatedFormat('d F Y');
  }
  public function dateactuelle()
  {
    Carbon::now()->translatedFormat('d F Y');
  }

  public function banque () : BelongsTo
  {
    return $this->belongsTo(Banque::class);
  }

  public function remise () : BelongsTo
  {
    return $this->belongsTo(Remise::class);
  }
  public function adherant(): BelongsTo
  {
    return $this->belongsTo(Adherant::class);
  }
  public function user() : BelongsTo
  {
    return  $this->belongsTo(User::class);
  }


}
