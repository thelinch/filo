<?php

namespace Filo\Categories\Domain;

use JsonSerializable;
use src\Shared\Domain\Aggregate\AggregateRoot;

class Category extends AggregateRoot implements JsonSerializable
{
    private CategoryId $id;
    private CategoryName $name;
    private CategoryUrl $url;
    public function __construct(CategoryId $id, CategoryName $name, CategoryUrl $url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
    }

    public function id(): CategoryId
    {
        return $this->id;
    }
    public function name(): CategoryName
    {
        return $this->name;
    }
    public function jsonSerialize()
    {
        return [
            "id" => $this->id->value(),
            "name" => $this->name->value(),
            "url" => $this->url->value()
        ];
    }
}
