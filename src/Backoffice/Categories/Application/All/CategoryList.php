<?php

namespace backoffice\Categories\Application\All;

use backoffice\Categories\Domain\CategoryRepository;

class CategoryList
{
    private CategoryRepository $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(): array
    {
        $list = $this->repository->list();
        return $list;
    }
}
