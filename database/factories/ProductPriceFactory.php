<?php

use Faker\Generator as Faker;
use \App\ProductPrice;
use Illuminate\Support\Facades\DB;



try {
    $factory->minId = DB::table('products')->orderBy('id', 'asc')->first()->id;
    $factory->maxId = DB::table('products')->orderBy('id', 'desc')->first()->id;
} catch (\Throwable $th) {
    $factory->minId = 1;
    $factory->maxId = 100;
}

$factory->define(ProductPrice::class, function (Faker $faker) {
    return [
        'product_id'    => random_int( $this->minId , $this->maxId ),
        'date'          => $faker->dateTimeThisYear,
        'price'         => random_int( 1 , 9999 )
    ];
});
