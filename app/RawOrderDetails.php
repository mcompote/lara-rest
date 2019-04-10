<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RawOrder;

class RawOrderDetails extends Model
{
    protected $table = "order_details";
    protected $guarded = [];

    public function rawOrder()
    {
        return $this->belongsTo(RawOrder::class);
    }
}
