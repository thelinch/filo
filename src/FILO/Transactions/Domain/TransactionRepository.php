<?php

namespace Filo\Transactions\Domain;

use Filo\Partners\Domain\PartnerId;
use Filo\Users\Domain\UserId;

interface TransactionRepository
{
    function create(Transaction $transaction): void;
    function findByPartner(PartnerId $partnerId): array;
    function findByUser(UserId $id): array;
    function findById(TransactionId $id): ?Transaction;
    function cancelled(Transaction $transaction): void;
}
