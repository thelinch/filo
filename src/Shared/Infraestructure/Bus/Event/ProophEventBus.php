<?php

namespace src\Shared\Infraestructure\Bus\Event;

use Filo\Menus\Application\Create\MenuCreator;
use Filo\Menus\Domain\MenuCreateDomainEvent;
use Filo\PartnerCounterDishes\Application\Increment\PartnerCounterDishesIncrement;
use Prooph\ServiceBus\EventBus as ServiceBusEventBus;
use Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use src\Shared\Domain\Bus\Event\DomainEvent;
use src\Shared\Domain\Bus\Event\EventBus;

class ProophEventBus implements EventBus
{

    private ServiceBusEventBus $bus;
    public function __construct(ServiceBusEventBus $bus)
    {
        $this->registerRouterEventBus($bus);
        $this->bus = $bus;
    }
    public function publish(DomainEvent ...$events)
    {
        foreach ($events as $event) {
            $this->bus->dispatch($event);
        }
    }

    private function registerRouterEventBus(ServiceBusEventBus $bus)
    {
        $router = new EventRouter([MenuCreateDomainEvent::class => [PartnerCounterDishesIncrement::class]]);
        $router->attachToMessageBus($bus);
    }
}
