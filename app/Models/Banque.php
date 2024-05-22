<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
