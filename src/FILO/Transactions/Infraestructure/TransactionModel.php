<?php

namespace Filo\Transactions\Infraestructure;

use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    protected $fillable = ["id", "user_id", "total", "state", "partner_id"];
    protected $keyType = 'string';
    protected $table = "transactions";
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $attributes  = [
        "state" => "1"
    ];

    public function details()
    {
        return $this->hasMany(TransactionModelDetail::class);
    }
}
