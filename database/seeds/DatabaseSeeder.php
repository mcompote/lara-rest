<?php

use Illuminate\Database\Seeder;


// source: https://stackoverflow.com/questions/33973967/why-do-i-have-to-run-composer-dump-autoload-command-to-make-migrations-work-in
// In case you get errors while trying to load Seeder classes, use this approach:
// -php artisan clear-compiled 
// -composer dump-autoload
// -php artisan optimize


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductPriceTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderDetailsTableSeeder::class);
    }
}
