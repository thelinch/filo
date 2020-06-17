<?php

namespace Filo\Partners\Infraestructure;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    public $fillable = ["id", "name"];
    protected $table = "cities";
}
