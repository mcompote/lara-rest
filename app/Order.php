<?php

namespace App;

use \App\RawOrder;
use \App\QueryScopes\OrderScope;

class Order extends RawOrder
{

    protected $guarded = ['is_cart'];

    //adding global scope to model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope);
    }
}
