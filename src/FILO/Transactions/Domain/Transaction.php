<?php

namespace Filo\Transactions\Domain;

use Filo\Partners\Domain\PartnerId;
use Filo\Users\Domain\UserId;
use JsonSerializable;
use src\Shared\Domain\Aggregate\AggregateRoot;

class Transaction extends AggregateRoot implements JsonSerializable
{
    private TransactionId $id;
    private TransactionTotal $total;
    private array $details;
    private PartnerId $partnerId;
    private TransactionState $state;
    private UserId $userId;
    private TransactionCode $code;
    public function __construct(UserId $userId, TransactionId $id, TransactionState $state, TransactionTotal $total, PartnerId $partnerId, array $details, TransactionCode $code)
    {
        $this->userId = $userId;
        $this->id = $id;
        $this->total = $total;
        $this->details = $details;
        $this->partnerId = $partnerId;
        $this->code = $code;
        $this->state = $state;
    }

    public static function create(UserId $userId, TransactionId $id, TransactionTotal $total, PartnerId $partnerId, array $details, TransactionCode $code): self
    {
        $transaction = new self($userId, $id, TransactionState::Received(), $total, $partnerId, $details, $code);
        $transaction->record(new TransactionCreatedDomainEvent($id->value(), $total->value(), $partnerId->value(), $details));
        return $transaction;
    }
    public function transitonStateToDelete(): void
    {
        $this->state = TransactionState::cancelled();
        $this->record(new TransactionStateTransitionToDeleteDomainEvent($this->id()->value()));
    }
    public function jsonSerialize()
    {
        return [
            "id" => $this->id->value(),
            "items" => $this->details,
            "total" => $this->total()->value(),
            "state" => $this->state()->value(),
            "code" => $this->code->value()
        ];
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
    public function state(): TransactionState
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
