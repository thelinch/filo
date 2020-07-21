<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePartner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name", 191);
            $table->string("description", 191);
            $table->string("direction", 191);
            $table->string("phone", 191);
            $table->integer("counterdishes");
            $table->integer("petitions");
            $table->float("amountdelivery");
            $table->uuid("user_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->string("state");
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
        Schema::dropIfExists('table_partner');
    }
}
