<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');            //PK
            $table->unsignedBigInteger('user_id');  //FK
            $table->text('description')->nullable();
            $table->string('status')->default('CREATED');   //TODO:MAKE `STATUSES` TABLE
            $table->double('subtotal', 10, 2)->default(0);
            $table->double('discount', 10, 2)->default(0);
            $table->double('total', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
