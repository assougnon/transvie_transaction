<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Remise extends Model
{
    use HasFactory;

    protected $fillable = [

      'image_url'
    ];
 public function transactions ():HasMany {
   return $this->hasMany(Transaction::class);
 }

}
