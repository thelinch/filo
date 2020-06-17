<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoryseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("categories")->insert([
            ["name" => "Polleria", "id" => "1"],
            ["name" => "Heladeria", "id" => "2"],
            ["name" => "Ferreteria", "id" => "3"],
            ["name" => "Muebleria", "id" => "4"],
            ["name" => "Tienda de Abarrotes", "id" => "5"]
        ]);
    }
}
