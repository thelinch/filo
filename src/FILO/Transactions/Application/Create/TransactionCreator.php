<?php

namespace Filo\Transactions\Application\Create;

use Filo\Partners\Domain\PartnerId;
use Filo\Transactions\Domain\Transaction;
use Filo\Transactions\Domain\TransactionCode;
use Filo\Transactions\Domain\TransactionId;
use Filo\Transactions\Domain\TransactionRepository;
use Filo\Transactions\Domain\TransactionTotal;
use Filo\Users\Domain\UserId;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Bus\Event\EventBus;
use src\Shared\Domain\CodeGenerator;
use src\Shared\Infraestructure\NativeCodeGenerator;

class TransactionCreator
{
    private TransactionRepository $repository;
    private CodeGenerator $codeGenerator;
    private EventBus $eventBus;
    public function __construct(TransactionRepository $repository, EventBus $bus)
    {
        $this->repository = $repository;
        $this->eventBus = $bus;
        $this->codeGenerator = App::make(NativeCodeGenerator::class);
    }
    public function __invoke(
        UserId $userId,
        TransactionId $id,
        TransactionTotal $total,
        PartnerId $partnerId,
        array $details
    ) {
        $transaction = Transaction::create($userId, $id, $total, $partnerId, $details, new TransactionCode($this->codeGenerator->generate()));
        $this->repository->create($transaction);
        //Mando a ejecutar un efecto secundario la cual lenvira un mensaje al wassap la cual sera asincrono
        $this->eventBus->publish(...$transaction->pullDomainEvents());
    }
}
