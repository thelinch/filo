<?php

namespace Filo\ShoppingCart\Domain;

use Filo\Transactions\Domain\TransactionCode;

interface paymentInterface
{
    public function pay(float $amount, float $discount, ItemShoppingCart ...$items): ?TransactionCode;
}
