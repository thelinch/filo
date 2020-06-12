<?php

namespace Filo\Transactions\Infraestructure\State;

use Spatie\ModelStates\State;




abstract class TransactionState extends State
{
    abstract public function name(): string;
}
