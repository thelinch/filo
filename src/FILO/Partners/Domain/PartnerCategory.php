<?php

namespace Filo\Partners\Domain;




class PartnerCategory
{

    private string $id;
    private string $name;
    public function __construct(string $id, string  $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id()
    {
        return $this->id;
    }
    public function name()
    {
        return $this->name;
    }
    public function changeCategory(string $newId, string $newName): self
    {
        return new self($newId, $newName);
    }
}
