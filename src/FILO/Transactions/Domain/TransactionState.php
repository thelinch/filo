<?php

namespace Filo\Transactions\Domain;

use Filo\Transactions\Infraestructure\ConcretState\OnMyWay;
use Filo\Transactions\Infraestructure\ConcretState\Received;
use src\Shared\Domain\ValueObject\StringValueObject;

class TransactionState extends StringValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
    public function isAllowedTransitionToCancelled()
    {

        if ($this->value() == "En Camino" || $this->value() == "Cancelado") {
            throw new TransitionNotAllowed();
            //Erorr
        }
        return true;
    }
    public function isAllowedTransitionToOnMyWay()
    {
        if ($this->value() == "En camino" || $this->value() == "Cancelado") {
            //Error
            throw new TransitionNotAllowed();
        }
        return true;
    }
    public function isAllowedTransitionToAttended()
    {
        if ($this->value() == "Atendido" || $this->value() == "Cancelado" || $this->value() == "Recibido") {
            //Error
            throw new TransitionNotAllowed();
        }
        return true;
    }
    public static function Received(): self
    {
        return new self("Recibido");
    }
    public static function OnMyWay(): self
    {
        return new self("En camino");
    }
    public static function cancelled(): self
    {

        return new self("Cancelado");
    }
    public static function attended(): self
    {
        return new self("Atendido");
    }
}
