<?php

namespace Filo\Partners\Infraestructure;

use Illuminate\Database\Eloquent\Model;

class DaysModel extends Model
{
    public $fillable = ["id", "name", "description", "state"];
    protected $table = "days";
}
