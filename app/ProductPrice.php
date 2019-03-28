<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    // protected $primaryKey = ['product_id', 'date'];
    // public $incrementing = false;

    protected $table = 'product_prices';

    public function product() {
        return $this->belongsTo('\App\Product');
    }
}
