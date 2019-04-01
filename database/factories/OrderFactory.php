<?php

use Faker\Generator as Faker;
use \App\Order;
use Illuminate\Support\Facades\DB;




$factory->define(App\Order::class, function (Faker $faker) {
    
    $statuses = ['CREATED', 'CONFIRMED', 'CANCELLED', 'FULFILLED', 'PROCESSING'];
    $minId = 1; 
    $maxId = 100;
    try {
        $minId = DB::table('users')->orderBy('id', 'asc')->first()->id;
        $maxId = DB::table('users')->orderBy('id', 'desc')->first()->id;
    } catch (\Throwable $th) {
        $minId = 1;
        $maxId = 100;
    }

    $subtotal = $faker->randomFloat($nbMaxDecimals = 10, $min = 0, $max = 100000);
    $discount = $faker->randomFloat($nbMaxDecimals = 10, $min = 0, $max = 1000);
    $total    = $subtotal - $discount;
    
    return [
        'user_id' => random_int( $minId, $maxId ),
        'status'  => $statuses[ random_int( 0, count($statuses)-1 ) ],
        'description' => $faker->text(50),
        'subtotal' => $subtotal,
        'discount' => $discount,
        'total' => $total,
    ];
});
