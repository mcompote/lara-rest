<?php

namespace App;

use \App\RawOrderDetails;
use \App\Order;
use \App\QueryScopes\OrderDetailsScope;


class OrderDetails extends RawOrderDetails
{

    //adding global scope to model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderDetailsScope);
    }  
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}
