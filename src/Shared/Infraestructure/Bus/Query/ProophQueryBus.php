<?php

namespace src\Shared\Infraestructure\Bus\Query;

use DirectRouter\DirectRouter;
use Filo\Partners\Application\Find\PartnerFinderQuery;
use Filo\Partners\Application\Find\PartnerFinderQueryHandler;
use Prooph\ServiceBus\Plugin\Router\QueryRouter;
use Prooph\ServiceBus\QueryBus as ServiceBusQueryBus;
use React\Promise\Deferred;
use src\Shared\Domain\Bus\Query\QueryBus;
use src\Shared\Domain\Bus\Query\Response;

class ProophQueryBus implements QueryBus
{
    private ServiceBusQueryBus $commandQeury;
    private JsonResponse $json;
    public function __construct(ServiceBusQueryBus $queryBus)
    {
        $this->registerRouterCommanQuery($queryBus);
        $this->commandQeury = $queryBus;
        $this->json = new JsonResponse();
    }
    public function ask(\src\Shared\Domain\Bus\Query\Query $query): ?Response
    {
        return  $this->commandQeury->dispatch($query)->done(function ($result) {
            dd($result);
            return  $result;
        });
    }
    private function registerRouterCommanQuery(ServiceBusQueryBus $queryBus)
    {
        /*   $directRouter = new DirectRouter();
        $directRouter->attachToMessageBus($queryBus); */
        $router = new QueryRouter();
        $router->route(PartnerFinderQuery::class)->to(new PartnerFinderQueryHandler());
        $router->attachToMessageBus($queryBus);
    }
}
