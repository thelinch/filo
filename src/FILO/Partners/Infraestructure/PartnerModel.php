<?php

namespace Filo\Partners\Infraestructure;

use backoffice\Categories\Infraestructure\CategoryModel;
use Filo\Menus\Infraestructure\MenuModel;
use Filo\Users\Domain\User;
use Filo\Users\Infraestructure\UserModel;
use Illuminate\Database\Eloquent\Model;

class PartnerModel extends Model
{
    protected $fillable = ["id", "name", "description", "state"];
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $attributes  = [
        "state" => 1
    ];
    protected $timestamp = false;
    public $table = "partners";
    public function workdays()
    {
        return $this->belongsToMany(DaysModel::class, "dayworks", "partner_id", "day_id")->withPivot(["starttime", "endtime", "state", "id"])->wherePivot("state", "<>", 0);
    }
    public function user()
    {
        return $this->hasOne(UserModel::class);
    }
    public function menus()
    {
        return $this->hasMany(MenuModel::class)->where("state", "<>", "0");
    }
    public function category()
    {
        return $this->belongsTo(CategoryModel::class);
    }
}
