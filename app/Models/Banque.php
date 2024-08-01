<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banque extends Model
{
    use HasFactory;

    protected $fillable = [
      'nom',
      'telephone',
      'pays_id',
      'image_url',
      'adresse'
    ];

  public function pays(): BelongsTo
  {
    return $this->belongsTo(Pays::class);
  }

  public function transactions(): HasMany
  {
    return $this->hasMany(Transaction::class);
  }
  public function depenses() : HasMany
  {
    return  $this->hasMany(Transacsortie::class);
  }

  public function depensesTotal()
  {
    return $this->depenses()->sum('montant');
  }
}
