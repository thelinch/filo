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
use Illuminate\Support\ServiceProvider;

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
            return new MenuCreator($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"));
        });
        $this->app->bind("menuFinder", function ($app) {
            return new MenuFinder($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"));
        });
        $this->app->bind("menuDelete", function ($app) {
            return new MenuDelete($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"));
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
