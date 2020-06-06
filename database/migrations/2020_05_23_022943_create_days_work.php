<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dayworks', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->time("starttime");
            $table->time("endtime");
            $table->uuid("partner_id");
            $table->foreign("partner_id")->references("id")->on("partners");
            $table->uuid("day_id");
            $table->foreign("day_id")->references("id")->on("days");
            $table->string("state")->default("1");
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
        Schema::dropIfExists('days_work');
    }
}
