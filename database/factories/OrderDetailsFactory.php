<?php

use Faker\Generator as Faker;
use \App\OrderDetails;
use Illuminate\Support\Facades\DB;

$factory->define(OrderDetails::class, function (Faker $faker) {
    $minOrderId = 1; 
    $maxOrderId = 100;

    $minProductId = 1; 
    $maxProductId = 100;
    try {
        $minOrderId     = DB::table('orders')->orderBy('id', 'asc')->first()->id;
        $maxOrderId     = DB::table('orders')->orderBy('id', 'desc')->first()->id;

        $minProductId   = DB::table('products')->orderBy('id', 'asc')->first()->id;
        $maxProductId   = DB::table('products')->orderBy('id', 'desc')->first()->id;
    } catch (\Throwable $th) {
        $minOrderId = 1;
        $maxOrderId = 100;

        $minProductId = 1; 
        $maxProductId = 100;
    }

    return [
        'order_id' => random_int( $minOrderId, $maxOrderId ),
        'product_id' => random_int( $minProductId, $maxProductId ),
        'quantity' => $faker->numberBetween($min = 1, $max = 90)
    ];
});
