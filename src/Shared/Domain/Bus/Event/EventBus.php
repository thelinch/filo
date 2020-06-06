<?php

namespace src\Shared\Domain\Bus\Event;


interface EventBus
{
    public function publish(DomainEvent ...$events);
}
