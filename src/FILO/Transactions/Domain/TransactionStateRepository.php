<?php

namespace Filo\Transactions\Domain;




interface TransactionStateRepository
{
    function cancelled(Transaction $transaction): void;
    function onMyWay(Transaction $transaction): void;
    function attended(Transaction $transaction): void;
}
