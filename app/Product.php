<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\ProductPrice;

class Product extends Model
{

    protected $fillable = ['name', 'description'];

    public function prices()
    {
        return $this->hasMany('\App\ProductPrice', 'product_id');
    }
}
