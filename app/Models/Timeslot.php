<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Timeslot extends Model
{
   protected $fillable = [
        'futsal_id',
        'date',
        'time_from',
        'time_to',
        'status',
    ];

   /**
    * Get the futsal that owns the Timeslot
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function futsal(): BelongsTo
   {
       return $this->belongsTo(Futsal::class);
   }
   /**
    * Get the reservation associated with the Timeslot
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function reservation(): HasOne
   {
       return $this->hasOne(Reservation::class);
   }
}
