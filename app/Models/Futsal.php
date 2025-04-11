<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Futsal extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'status',
        'image',
        'rate',
        'description',
        'facilities',
        'user_id',
    ];
    /**
     * Get all of the reservations for the Futsal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
    /**
     * Get all of the customers for the Futsal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /**
     * Get all of the timeslots for the Futsal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timeslots(): HasMany
    {
        return $this->hasMany(Timeslot::class);
    }
    /**
     * Get the user that owns the Futsal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
