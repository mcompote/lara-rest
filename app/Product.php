<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\ProductPrice;
use \App\RawOrderDetails;

class Product extends Model
{

    protected $fillable = ['name', 'description'];

    public function prices()
    {
        return $this->hasMany('\App\ProductPrice', 'product_id');
    }




    
    public function rawOrderDetails()
    {
        return $this->hasMany('\App\RawOrderDetails', 'product_id');
    }

    public function orderDetails()
    {
        return $this->hasMany('\App\orderDetails', 'product_id');
    }

    public function cartDetails()
    {
        return $this->hasMany('\App\cartDetails', 'product_id');
    }

}
