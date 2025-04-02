<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'date',
        'time_from',
        'time_to',
        'amount',
        'payment_type',
        'payment_screenshot',
        'reservation_code',
        'customer_id',
        'futsal_id',
        'timeslot_id',
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    /**
     * Get all of the futsals for the Reservation
     *
     * @return \Illuminate\DatFutsalloquent\Relations\HasMany
     */
    /**
     * Get the futsal that owns the Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function futsal(): BelongsTo
    {
        return $this->belongsTo(Futsal::class);
    }
}
