<?php

namespace Filo\Categories\Infraestructure;

use Filo\Categories\Domain\Category;
use Filo\Categories\Domain\CategoryId;
use Filo\Categories\Domain\CategoryName;
use Filo\Categories\Domain\CategoryRepository;
use Filo\Categories\Domain\CategoryUrl;

class EloquentCategory implements CategoryRepository
{
    private CategoryModel $model;

    public function __construct(CategoryModel $model)
    {
        $this->model = $model;
    }
    function all(): array
    {
        $categoriesModel = collect($this->model->where("state", "<>", "0")->select("id", "name", "url")->get())
            ->map(fn ($categoryModel) => new Category(
                new CategoryId($categoryModel->id),
                new CategoryName($categoryModel->name),
                new CategoryUrl($categoryModel->url)
            ));

        return $categoriesModel->toArray();
    }
}
