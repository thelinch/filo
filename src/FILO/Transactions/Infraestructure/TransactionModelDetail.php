<?php

namespace Filo\Transactions\Infraestructure;

use Filo\Menus\Infraestructure\MenuModel;
use Illuminate\Database\Eloquent\Model;


class TransactionModelDetail extends Model
{
    protected $fillable = ["id", "quantity", "transaction_id", "menu_id",];
    protected $keyType = 'string';
    protected $table = "transactionsdetails";
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $attributes  = [
        "state" => "1"
    ];
    public function transaction()
    {
        return $this->belongsTo(TransactionModel::class);
    }
    public function menu()
    {
        return $this->belongsTo(MenuModel::class);
    }
}
