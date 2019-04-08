<?php

namespace App;

use \App\RawOrder;
use \App\CartDetalis;
use \App\QueryScopes\CartScope;

class Cart extends RawOrder
{
    protected $guarded = ['is_cart'];

    //adding global scope to model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CartScope);

        //ALWAYS set field 'is_cart' to TRUE for 'Cart' entities at creation time (not for the updates)
        static::creating(function ($query) {
            $query->is_cart = true;
        });
    }

    public function details()
    {
        return $this->hasMany(CartDetails::class, 'order_id', 'id');
    }    

}
