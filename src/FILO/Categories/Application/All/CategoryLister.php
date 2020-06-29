<?php

namespace Filo\Categories\Application\All;

use Filo\Categories\Domain\CategoryRepository;

class CategoryLister
{
    private CategoryRepository $repository;
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): array
    {
        return $this->repository->all();
    }
}
