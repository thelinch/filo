<?php


namespace backoffice\Categories\Domain;

use src\Shared\Domain\Aggregate\AggregateRoot;

class Category extends AggregateRoot
{

    private CategoryId $id;
    private CategoryName $name;

    public function __construct(CategoryId $id, CategoryName $name)
    {

        $this->id = $id;
        $this->name = $name;
    }

    public function id(): CategoryId
    {
        return $this->id;
    }

    public function name(): CategoryName
    {
        return $this->name;
    }
}
