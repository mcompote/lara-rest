<?php

use Illuminate\Database\Seeder;
use \App\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 100)->create();

        // try {
        //     factory(ProductPrice::class, 2000)->create();
        // } catch (\Throwable $th) {
        //     // var_dump($th);
        // }
    }
}
