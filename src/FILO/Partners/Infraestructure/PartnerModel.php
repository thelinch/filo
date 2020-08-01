<?php

namespace Filo\Partners\Infraestructure;

use Carbon\Carbon;
use Filo\Categories\Infraestructure\CategoryModel;
use Filo\Menus\Infraestructure\MenuModel;
use Filo\Users\Domain\User;
use Filo\Users\Infraestructure\UserModel;
use Illuminate\Database\Eloquent\Model;

class PartnerModel extends Model
{
    protected $fillable = ["id", "name", "user_id", "phone", "email", "address", "description", "state"];
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $table = "partners";
    public $incrementing = false;
    protected $attributes  = [
        "state" => 1
    ];
    protected $timestamp = false;
    public function workdays()
    {
        return $this->belongsToMany(DaysModel::class, "dayworks", "partner_id", "day_id")->withPivot(["starttime", "endtime", "state", "id"])->wherePivot("state", "<>", 0);
    }
    public function setDateAttribute($value)
    {
        $this->attributes["pivot"]['starttime'] = (new Carbon($value))->format('d/m/y');
        $this->attributes["pivot"]['endtime'] = (new Carbon($value))->format('d/m/y');
    }
    public function user()
    {
        return $this->hasOne(UserModel::class);
    }
    public function menus()
    {
        return $this->hasMany(MenuModel::class, "partner_id")->where("state", "<>", "0");
    }
    public function city()
    {
        return $this->belongsTo(CityModel::class);
    }
    public function category()
    {
        return $this->belongsTo(CategoryModel::class);
    }
}
