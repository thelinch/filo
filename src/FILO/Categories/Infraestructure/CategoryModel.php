<?php

namespace Filo\Categories\Infraestructure;

use Filo\Partners\Infraestructure\PartnerModel;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = "categories";
    protected $fillable = ["name", "url", "votes", "state", "partner_id"];
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $attributes  = [
        "state" => 1
    ];
    public function partner()
    {
        return $this->belongsTo(PartnerModel::class);
    }
}
