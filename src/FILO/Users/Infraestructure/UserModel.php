<?php

namespace Filo\Users\Infraestructure;

use Filo\Partners\Infraestructure\PartnerModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserModel extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;
    protected $fillable = ["id", "name", "email", "password", "phone", "direction"];
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guard_name = "api";
    /*  protected $attributes  = [
        "state" => 1
    ]; */
    protected $timestamp = false;
    protected $table = "users";
    public function partner()
    {
        return $this->hasOne(PartnerModel::class, "user_id");
    }
}
