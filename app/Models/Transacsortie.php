<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transacsortie extends Model
{
    use HasFactory;
    protected  $fillable = [
      'banque_id',
      'montant',
      'description'
    ];
  protected $table = 'transactions_sorties';

  public function banque () : BelongsTo
  {
    return $this->belongsTo(Banque::class);
  }
}
