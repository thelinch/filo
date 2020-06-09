<?php

namespace src\Shared\Infraestructure\Bus\Event;

use src\Shared\Domain\Bus\Event\DomainEvent;
use src\Shared\Domain\Bus\Event\EventBus;

class LaravelEventBus implements EventBus
{

    public function publish(DomainEvent ...$events)
    {
        foreach ($events as $event) {
            event($event);
        }
    }
}
