<?php

namespace Filo\Transactions\Infraestructure;

use Filo\Partners\Infraestructure\PartnerModel;
use Filo\Transactions\Infraestructure\ConcretState\Attended;
use Filo\Transactions\Infraestructure\ConcretState\Cancelled;
use Filo\Transactions\Infraestructure\ConcretState\OnMyWay;
use Filo\Transactions\Infraestructure\ConcretState\Received;
use Filo\Transactions\Infraestructure\State\TransactionState;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

class TransactionModel extends Model
{
    use HasStates;
    protected $fillable = ["id", "user_id", "total", "state", "partner_id", "code", "amountpayment", "direction", "phone"];
    protected $keyType = 'string';
    protected $table = "transactions";
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected function registerStates(): void
    {
        $this->addState("state", TransactionState::class)
            ->allowTransitions([
                [Received::class, OnMyWay::class],
                [OnMyWay::class, Attended::class],
                [Received::class, Cancelled::class]
            ])->default(Received::class);
    }
    public function details()
    {
        return $this->hasMany(TransactionModelDetail::class, "transaction_id");
    }
    public function partner()
    {
        return $this->belongsTo(PartnerModel::class);
    }
}
