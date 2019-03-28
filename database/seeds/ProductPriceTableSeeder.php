<?php

use Illuminate\Database\Seeder;
use \App\ProductPrice;

class ProductPriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(ProductPrice::class, 2000)->create();

        try {
            factory(ProductPrice::class, 2000)->create();
        } catch (\Throwable $th) {
            // var_dump($th);
        }
    }
}
