<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;
use \App\RawOrderDetails;

class OrderDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    
        $faker = new Faker();
        $duplicates = 0;
        for ($i=0; $i < 10000; $i++) { 
            try {
                RawOrderDetails::create([
                    'order_id' => random_int( $minOrderId, $maxOrderId ),
                    'product_id' => random_int( $minProductId, $maxProductId ),
                    'quantity' => random_int(1,90)
                ]);
            } catch (\Throwable $th) {
                $duplicates++;
            }
        }
        echo "UNIQ restirction violations: ", $duplicates, "\n";

        
        // try {
        //     factory(OrderDetails::class, 10000)->create();
        // } catch (\Throwable $th) {
        //     // var_dump($th);
        // }

    }
}
