<?php

namespace Filo\Menus\Infraestructure;

use Filo\Partners\Infraestructure\PartnerModel;
use Filo\Transactions\Domain\TransactionDetail;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table = "menus";
    protected $fillable = ["name", "price", "votes", "state", "partner_id"];
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
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, "menu_id");
    }
}
