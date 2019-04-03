<?php

use Illuminate\Database\Seeder;
use \App\OrderDetails;

class OrderDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        try {
            factory(OrderDetails::class, 10000)->create();
        } catch (\Throwable $th) {
            // var_dump($th);
        }

    }
}
