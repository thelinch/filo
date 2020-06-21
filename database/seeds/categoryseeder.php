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
            ["name" => "Polleria", "id" => "1", "url" => "/img/heladeria.jpg"],
            ["name" => "Heladeria", "id" => "2", "url" => "/img/heladeria.jpg"],
            ["name" => "Ferreteria", "id" => "3", "url" => "wdwd"],
            ["name" => "Muebleria", "id" => "4", "url" => "wdwd"],
            ["name" => "Tienda de Abarrotes", "id" => "5", "url" => "/img/abarrotes.jpg"]
        ]);
    }
}
