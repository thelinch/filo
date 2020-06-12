<?php

namespace App\Providers;

use Filo\Menus\Domain\MenuCreateDomainEvent;
use Filo\Menus\Domain\MenuDeleteDomainEvent;
use Filo\PartnerCounterDishes\Application\Decrement\PartnerCounterDishesDecrement;
use Filo\PartnerCounterDishes\Application\Increment\PartnerCounterDishesIncrement;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MenuCreateDomainEvent::class => [PartnerCounterDishesIncrement::class],
        MenuDeleteDomainEvent::class => [PartnerCounterDishesDecrement::class]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
