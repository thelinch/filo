<?php

namespace Filo\Users\Domain;

use src\Shared\Domain\Aggregate\AggregateRoot;

class User extends AggregateRoot
{

    private UserId $id;
    private UserDirection $direction;
    private UserName $name;
    private UserPhone $phone;
    public function __construct(UserId $id, UserDirection $direction, UserName $name, UserPhone $phone)
    {
        $this->id = $id;
        $this->direction = $direction;
        $this->name = $name;
        $this->phone = $phone;
    }
    public function id(): UserId
    {
        return $this->id;
    }

    public function direction(): UserDirection
    {
        return $this->direction;
    }

    public function name(): UserName
    {
        return $this->name;
    }
    public function phone(): UserPhone
    {
        return $this->phone;
    }
}
