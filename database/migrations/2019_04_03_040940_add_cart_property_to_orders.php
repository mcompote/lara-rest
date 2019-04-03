<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

// Adding 'is_cart' field to 'orders', since 'orders' and 'cart' tables seems to be absolutely equal
class AddCartPropertyToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->addColumn('boolean', 'is_cart')->default(false);
        });

        // DB::statement( $this->dropView() );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->removeColumn('is_cart');
        });
    }



    // private function dropView(): string
    // {
    //     return <<<SQL
    //         DROP VIEW IF EXISTS `carts`;
    //     SQL;
    // }

    // private function createView(): string
    // {
    //     return <<<SQL
    // CREATE ALGORITHM = MERGE SQL SECURITY DEFINER VIEW `carts` AS SELECT * FROM orders WHERE orders.is_cart = TRUE ;
    //     SQL;
    // }
}
