<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\ProductPrice;

class Product extends Model
{
    public function prices()
    {
        return $this->hasMany('\App\ProductPrice', 'product_id');
    }
}
