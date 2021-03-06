<?php

namespace Filo\Partners\Domain;

use JsonSerializable;

class PartnerCity implements JsonSerializable
{
    private int $id;
    private string $name;
    public function __construct(int $id, string $name)
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
    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name
        ];
    }
}
