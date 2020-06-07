<?php

namespace Filo\Transactions\Domain;

use Filo\Partners\Domain\PartnerId;
use Filo\Users\Domain\UserId;
use src\Shared\Domain\Aggregate\AggregateRoot;

class Transaction extends AggregateRoot
{
    private TransactionId $id;
    private TransactionTotal $total;
    private array $details;
    private PartnerId $partnerId;
    private string $state;
    private UserId $userId;
    private TransactionCode $code;
    public function __construct(UserId $userId, TransactionId $id, string $state, TransactionTotal $total, PartnerId $partnerId, array $details, TransactionCode $code)
    {
        $this->userId = $userId;
        $this->id = $id;
        $this->total = $total;
        $this->details = $details;
        $this->partnerId = $partnerId;
        $this->code = $code;
        $this->state = $state;
    }

    public static function create(UserId $userId, TransactionId $id, string $state, TransactionTotal $total, PartnerId $partnerId, array $details, TransactionCode $code): self
    {
        $transaction = new self($userId, $id, $state, $total, $partnerId, $details, $code);
        $transaction->record(new TransactionCreatedDomainEvent($id->value(), $total->value(), $partnerId->value(), $details));
        return $transaction;
    }

    public function code(): TransactionCode
    {
        return  $this->code;
    }
    public function generateCode()
    {
    }
    public function userId(): UserId
    {
        return $this->userId;
    }
    public function state(): string
    {

        return $this->state;
    }
    public function id(): TransactionId
    {
        return $this->id;
    }
    public function total(): TransactionTotal
    {
        return $this->total;
    }

    public function details(): array
    {
        return $this->details;
    }

    public function partnerId(): PartnerId
    {
        return $this->partnerId;
    }
}
