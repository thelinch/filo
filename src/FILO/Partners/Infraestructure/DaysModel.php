<?php

namespace Filo\Partners\Infraestructure;

use Illuminate\Database\Eloquent\Model;

class DaysModel extends Model
{
    public $fillable = ["id", "name", "description", "state"];
    protected $table = "days";

    public function partners()
    {
        return $this->belongsToMany(PartnerModel::class, "dayworks", "day_id", "partner_id");
    }
}
