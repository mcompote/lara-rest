<?php

namespace App;

use \App\RawOrderDetails;
use \App\QueryScopes\OrderDetailsScope;


class OrderDetails extends RawOrderDetails
{

    //adding global scope to model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderDetailsScope);
    }    
}
