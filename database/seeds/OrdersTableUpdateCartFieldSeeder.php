<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as FakerGen;

class OrdersTableUpdateCartFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get list containing all id's from orders table
        $ids = DB::table('orders')
            ->select('id')
            ->get()
            ->map( function ($obj) { return $obj->id; } )
            ->all();
        
        $faker = FakerGen::create();
        foreach ($ids as $key => $value) {
            DB::table('orders')
            ->where('id', $value)
            ->update(['is_cart' => $faker->boolean($chanceOfGettingTrue = 65)]);
        }
    }
}
