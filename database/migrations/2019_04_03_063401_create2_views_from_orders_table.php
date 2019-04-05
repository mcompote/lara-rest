<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create2ViewsFromOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // // Schema::rename('orders', 'orders_carts');
        // // Schema::table('order_details', function (Blueprint $table) {
        // //     $table->dropForeign(['order_id']);
        // //     $table->foreign('order_id')
        // //         ->references('id')
        // //         ->on('orders_carts')
        // //         ->onDelete('cascade');
        // // });

        // DB::statement( $this->createViews() );
        
        DB::connection()->getPdo()->exec( $this->dropViews() );        
        DB::connection()->getPdo()->exec( $this->createViews() );
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement( $this->dropViews() );
        DB::connection()->getPdo()->exec( $this->dropViews() );

        // // Schema::rename('orders_carts', 'orders');
        // // Schema::table('order_details', function (Blueprint $table) {
        // //     $table->dropForeign(['order_id']);
        // //     $table->foreign('order_id')
        // //         ->references('id')
        // //         ->on('orders')
        // //         ->onDelete('cascade');
        // // });
    }


    private function dropViews():string
    {
        return <<<SQL
            DROP VIEW IF EXISTS `v_carts`;
            DROP VIEW IF EXISTS `v_orders`;
        SQL;
    }

    private function createViews():string
    {
        return <<<SQL
            CREATE ALGORITHM = MERGE SQL SECURITY DEFINER VIEW `v_carts` AS SELECT * FROM `orders` WHERE `orders`.`is_cart` = TRUE;
            CREATE ALGORITHM = MERGE SQL SECURITY DEFINER VIEW `v_orders` AS SELECT * FROM `orders` WHERE `orders`.`is_cart` = FALSE;
        SQL;
    }
}
