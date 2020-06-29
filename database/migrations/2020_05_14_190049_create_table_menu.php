<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name", 191);
            $table->float("price");
            $table->integer("votes");
            $table->uuid("partner_id");
            $table->string("photo", 191);
            $table->text("description");
            $table->integer("state");
            $table->foreign("partner_id")->references("id")->on("partners");
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
        Schema::dropIfExists('table_menu');
    }
}
