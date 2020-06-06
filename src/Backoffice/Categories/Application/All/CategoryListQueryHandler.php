<?php

namespace backoffice\Categories\Application\All;

use Illuminate\Support\Facades\App;
use React\Promise\Deferred;
use src\Shared\Domain\Bus\Query\QueryHandler;

class PartnerFinderQueryHandler implements QueryHandler
{
    private CategoryList $list;
    public function __construct()
    {
        $this->list = App::make();
    }

    public function __invoke(CategoryListQuery $query, Deferred $deferred)
    {
        $list = $this->list->__invoke();
        $deferred->resolve($list);
    }
}
