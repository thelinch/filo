<?php

namespace backoffice\Categories\Infraestructure;

use backoffice\Categories\Domain\Category;
use backoffice\Categories\Domain\CategoryId;
use backoffice\Categories\Domain\CategoryRepository;

class EloquentCategoryRepository implements CategoryRepository
{
    function create(Category $category): void
    {
        $categoryModel = new CategoryModel();
        $categoryModel->id = $category->id()->value();
        $categoryModel->name = $category->name()->value();
        $categoryModel->save();
    }
    function findById(CategoryId $id): ?Category
    {
        return CategoryModel::find($id->value());;
    }
}
