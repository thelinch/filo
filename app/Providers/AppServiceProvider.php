<?php

namespace App\Providers;

use Filo\Categories\Domain\CategoryRepository;
use Filo\Categories\Infraestructure\EloquentCategory;
use Filo\Menus\Application\Create\MenuCreator;
use Filo\Menus\Application\Delete\MenuDelete;
use Filo\Menus\Application\Find\MenuFinder;
use Filo\Menus\Domain\MenuRepositoryI;
use Filo\Menus\Infraestructure\EloquentMenuRepository;
use Filo\PartnerCounterDishes\Domain\PartnerCounterDishesRepository;
use Filo\PartnerCounterDishes\Infraestructure\EloquentCounterDishesRepository;
use Filo\Partners\Application\All\PartnerList;
use Filo\Partners\Application\Create\PartnerCreator;
use Filo\Partners\Application\Delete\PartnerDelete;
use Filo\Partners\Application\Find\PartnerFinder;
use Filo\Partners\Application\Update\PartnerUpdate;
use Filo\Partners\Domain\PartnerRepositoryI;
use Filo\Partners\Infraestructure\EloquentPartnerRepository;
use Filo\Transactions\Application\Create\TransactionCreator;
use Filo\Transactions\Application\Delete\TransactionDeleter;
use Filo\Transactions\Application\FindByPartner\TransactionFindByPartner;
use Filo\Transactions\Domain\Services\TransactionFinder;
use Filo\Transactions\Domain\TransactionStateRepository;
use Filo\Transactions\Infraestructure\EloquentTransactionState;
use Filo\Users\Application\Create\UserCreator;
use Filo\Users\Application\Delete\UserDelete;
use Filo\Users\Application\Find\UserFinder;
use Filo\Users\Application\Update\UserUpdated;
use Filo\Users\Domain\JwtAuth;
use Filo\Users\Infraestructure\PassportAuth;
use Illuminate\Support\ServiceProvider;
use src\Shared\Domain\Bus\Event\EventBus;
use src\Shared\Domain\CodeGenerator;
use src\Shared\Infraestructure\Bus\Event\LaravelEventBus;
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
            JwtAuth::class,
            PassportAuth::class
        );
        $this->app->bind(
            PartnerRepositoryI::class,
            EloquentPartnerRepository::class
        );
        $this->app->bind(
            MenuRepositoryI::class,
            EloquentMenuRepository::class
        );
        $this->app->bind(
            PartnerCounterDishesRepository::class,
            EloquentCounterDishesRepository::class
        );
        $this->app->bind(
            CategoryRepository::class,
            EloquentCategory::class
        );
        $this->app->bind(
            TransactionStateRepository::class,
            EloquentTransactionState::class
        );

        $this->app->bind(
            EventBus::class,
            LaravelEventBus::class
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
            return new MenuCreator($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"), $app->make("src\Shared\Infraestructure\Bus\Event\LaravelEventBus"));
        });
        $this->app->bind("menuFinder", function ($app) {
            return new MenuFinder($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"));
        });
        $this->app->bind("menuDelete", function ($app) {
            return new MenuDelete($app->make("Filo\Menus\Infraestructure\EloquentMenuRepository"), $app->make("src\Shared\Infraestructure\Bus\Event\LaravelEventBus"));
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

        //Transaction
        $this->app->bind("transactionCreator", function ($app) {
            return new TransactionCreator($app->make("Filo\Transactions\Infraestructure\EloquentTransaction"), $app->make("src\Shared\Infraestructure\Bus\Event\LaravelEventBus"));
        });

        $this->app->bind("transactionFindByPartner", function ($app) {
            return new TransactionFindByPartner($app->make("Filo\Transactions\Infraestructure\EloquentTransaction"));
        });
        $this->app->bind("transactionFinder", function ($app) {
            return new TransactionFinder($app->make("Filo\Transactions\Infraestructure\EloquentTransaction"));
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
