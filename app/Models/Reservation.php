<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
    /**
     * Get all of the futsals for the Reservation
     *
     * @return \Illuminate\DatFutsalloquent\Relations\HasMany
     */
    public function futsals(): HasMany
    {
        return $this->hasMany(Futsal::class);
    }
}
