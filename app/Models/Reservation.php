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
        'user_id',
        'futsal_id',
        'timeslot_id',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
    /**
     * Get the timeslot that owns the Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class,);
    }
}
