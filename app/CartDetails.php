<?php

namespace App;

use \App\RawOrderDetails;
use \App\QueryScopes\CartDetailsScope;

class CartDetails extends RawOrderDetails
{

    //adding global scope to model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CartDetailsScope);
    }
}
