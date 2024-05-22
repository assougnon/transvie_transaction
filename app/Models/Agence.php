<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agence extends Model
{
  use HasFactory;

  public function users(): HasMany
  {

    $this->hasMany(User::class);
  }

  public function pays(): BelongsTo
  {
      return $this->belongsTo(Pays::class);
  }
  public function transactions() : hasMany
  {
    return $this->hasMany(Transaction::class);
  }
}
