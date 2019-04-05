<?php

namespace App;

use \App\RawOrderDetails;
use \App\QueryScopes\OrderDetailsScope;


class OrderDetails extends RawOrder
{

    //adding global scope to model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderDetailsScope);
    }    
}
