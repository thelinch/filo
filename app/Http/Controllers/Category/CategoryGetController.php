<?php

namespace App\Http\Controllers\Category;

use Filo\Categories\Application\All\CategoryLister;
use Illuminate\Support\Facades\App;
use src\Shared\Infraestructure\Eloquent\ApiController;

class CategoryGetController extends ApiController
{

    private CategoryLister $lister;
    public function exceptions(): array
    {
        return [];
    }
    public function __construct()
    {
        $this->lister = App::make(CategoryLister::class);
    }

    public function __invoke()
    {
        return $this->lister->__invoke();
    }
}
