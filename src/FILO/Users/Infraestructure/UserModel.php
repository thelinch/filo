<?php

namespace Filo\Users\Infraestructure;

use Filo\Partners\Infraestructure\PartnerModel;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $fillable = ["id", "name", "email", "password", "phone", "direction"];
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    /*  protected $attributes  = [
        "state" => 1
    ]; */
    protected $timestamp = false;
    protected $table = "users";
    public function partner()
    {
        return $this->belongsTo(PartnerModel::class);
    }
}
