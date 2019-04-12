<?php

namespace App;

use \App\RawOrder;
use \App\OrderDetails;
use \App\User;
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


    public function details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //same function declaration in 'Cart' model
    public function getProductsArray()
    {
       $result = $this->details->map(function ($item, $key) {
         return [ 'product_id' => $item->product_id,
                   'quantity'  => $item->quantity ];
      })->values()->toArray();

      return $result;
    }

    public function getFullInfoArray()
    {
        return [
            'orderId'   => $this->id,
            'status'    => $this->status,
            'subtotal'  => $this->subtotal,
            'discount'  => $this->discount,
            'total'     => $this->total,
            'details'   => $this->getProductsArray()

        ];
    }
}
