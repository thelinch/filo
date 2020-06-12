<?php

namespace Filo\Transactions\Infraestructure\TransitionState;

use Filo\Transactions\Infraestructure\ConcretState\Cancelled;
use Filo\Transactions\Infraestructure\ConcretState\Received;
use Filo\Transactions\Infraestructure\TransactionModel;
use Spatie\ModelStates\Transition;

class ReceivedToCancelled extends Transition
{
    /**@var TransactionModel*/
    private $transaction;
    public function __construct(TransactionModel $transaction)
    {
        $this->transaction = $transaction;
    }
    public function handle(): TransactionModel
    {
        $this->transaction->state = new Cancelled($this->transaction);
        $this->transaction->save();
        return $this->transaction;
    }
    public function canTransition(): bool
    {
        return   $this->transaction->is(Received::class);
    }
}
