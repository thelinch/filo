<?php

namespace App\Providers;

use Filo\Menus\Application\Create\MenuCreator;
use Filo\Menus\Application\Delete\MenuDelete;
use Filo\Menus\Application\Find\MenuFinder;
use Filo\Partners\Application\All\PartnerList;
use Filo\Partners\Application\Create\PartnerCreator;
use Filo\Partners\Application\Delete\PartnerDelete;
use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Application\Update\PartnerUpdate;
use Filo\Partners\Domain\PartnerRepositoryI;
use Filo\Partners\Infraestructure\EloquentPartnerRepository;
use Filo\Users\Application\Create\UserCreator;
use Filo\Users\Application\Delete\UserDelete;
use Filo\Users\Application\Find\UserFinder;
use Filo\Users\Application\Update\UserUpdated;
use Illuminate\Support\ServiceProvider;
use src\Shared\Domain\Bus\Event\EventBus;
use src\Shared\Domain\CodeGenerator;
use src\Shared\Infraestructure\Bus\Event\ProophEventBus;
use src\Shared\Infraestructure\NativeCodeGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            PartnerRepositoryI::class,
            EloquentPartnerRepository::class
        );
        $this->app->bind(
            EventBus::class,
            ProophEventBus::class
        );
        $this->app->bind(
            CodeGenerator::class,
            NativeCodeGenerator::class
        );
        $this->app->bind("partnerFinder", function ($app) {
            return new PartnerFinder($app->make("Filo\Partners\Infraestructure\EloquentPartnerRepository"));
        });
        $this->app->bind("partnerList", function ($app) {
            return new PartnerList($app->make("Filo\Partners\Infraestructure\EloquentPartnerRepository"));
        });
        $this->app->bind("partnerCreator", function ($app) {
            return new PartnerCreator($app->make("Filo\Partners\Infraestructure\EloquentPartnerRepository"));
        });


        $this->app->bind("partnerUpdate", function ($app) {
            return new PartnerUpdate($app->make("Filo\Partners\Infraestructure\EloquentPartnerRepository"));
        });
        $this->app->bind("partnerDelete", function ($app) {
            return new PartnerDelete($app->make("Filo\Partners\Infraestructure\EloquentPartnerRepository"));
        });

        $this->app->bind("menuCreator", function ($app) {
            return new MenuCreator($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"), $app->make("src\Shared\Infraestructure\Bus\Event\ProophEventBus"));
        });
        $this->app->bind("menuFinder", function ($app) {
            return new MenuFinder($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"));
        });
        $this->app->bind("menuDelete", function ($app) {
            return new MenuDelete($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"));
        });

        //USER
        $this->app->bind("userCreator", function ($app) {
            return new UserCreator($app->make("Filo\Users\Infraestructure\EloquentUserRepository"));
        });
        $this->app->bind("userFinder", function ($app) {
            return new UserFinder($app->make("Filo\Users\Infraestructure\EloquentUserRepository"));
        });
        $this->app->bind("userUpdated", function ($app) {
            return new UserUpdated($app->make("Filo\Users\Infraestructure\EloquentUserRepository"));
        });
        $this->app->bind("userDelete", function ($app) {
            return new UserDelete($app->make("Filo\Users\Infraestructure\EloquentUserRepository"));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
