<?php

namespace backoffice\Categories\Infraestructure;

use Filo\Partners\Infraestructure\PartnerModel;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = "categories";
    protected $fillable = ["id", "name", "state"];
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $attributes  = [
        "state" => 1
    ];
    protected $timestamp = false;
    public function partners()
    {
        return $this->hasMany(PartnerModel::class, "category_id", "partner_id");
    }
}
