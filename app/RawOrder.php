<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\User;
use \App\RawOrderDetails;

class RawOrder extends Model
{
    protected $table = 'orders';


    /**
     * Scope a query to only include cartDetails belongign to concrete user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rawDetails()
    {
        return $this->hasMany(RawOrderDetails::class);
    }
}
