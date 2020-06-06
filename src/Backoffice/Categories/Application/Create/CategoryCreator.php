<?php

namespace backoffice\Categories\Application\Create;

use backoffice\Categories\Domain\Category;
use backoffice\Categories\Domain\CategoryId;
use backoffice\Categories\Domain\CategoryName;
use backoffice\Categories\Domain\CategoryRepository;

class CategoryCreator
{
    private CategoryRepository $repository;
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(CategoryId $id, CategoryName $name): void
    {
        $category = new Category($id, $name);
        $this->repository->create($category);
    }
}
