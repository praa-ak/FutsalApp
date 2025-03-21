<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $fillable = [
        'email',
        'password',
        'customer_id',
        'futsal_id',
    ];
    /**
     * Get all of the comments for the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
    /**
     * Get all of the futsals for the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function futsals(): HasMany
    {
        return $this->hasMany(Futsal::class);
    }
}
