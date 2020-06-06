<?php

namespace Filo\Transactions\Domain;

use Filo\Partners\Domain\PartnerId;

interface TransactionRepository
{
    function create(Transaction $transaction): void;
    function findByPartner(PartnerId $partnerId): array;
    function findByUser(): array;
}
