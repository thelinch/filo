<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactionsdetails', function (Blueprint $table) {
            $table->increments("id");
            $table->float("quantity");
            $table->uuid("transaction_id");
            $table->foreign("transaction_id")->references("id")->on("transactions");
            $table->uuid("menu_id");
            $table->foreign("menu_id")->references("id")->on("menus");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactionsdetails');
    }
}
