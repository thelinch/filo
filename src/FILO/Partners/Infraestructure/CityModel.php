<?php

namespace Filo\Partners\Infraestructure;

use Filo\Users\Infraestructure\UserModel;
use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    public $fillable = ["id", "name"];
    protected $table = "cities";

    public function users()
    {
        return $this->hasMany(UserModel::class, "city_id");
    }
}
