<?php

namespace backoffice\Categories\Domain;

interface CategoryRepository
{
    function create(Category $category): void;
    function findById(CategoryId $id): ?Category;
    function list(): array;
}
