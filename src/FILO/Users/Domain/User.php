<?php

namespace Filo\Users\Domain;

use JsonSerializable;
use src\Shared\Domain\Aggregate\AggregateRoot;

class User extends AggregateRoot  implements JsonSerializable
{

    private UserId $id;
    private UserDirection $direction;
    private UserName $name;
    private UserPhone $phone;
    private UserPassword $password;
    private UserEmail $email;
    public function __construct(
        UserId $id,
        UserDirection $direction,
        UserName $name,
        UserPhone $phone,
        UserPassword $password,
        UserEmail $email
    ) {
        $this->id = $id;
        $this->direction = $direction;
        $this->name = $name;
        $this->phone = $phone;
        $this->password = $password;
        $this->email = $email;
    }
    public static function create(UserId $id, UserName $name, UserDirection $direction, UserEmail $email, UserPassword $password, UserPhone $phone): self
    {

        return new self($id, $direction, $name, $phone, $password, $email);
    }
    public function jsonSerialize()
    {
        return [
            "id" => $this->id->value(),
            "name" => $this->name()->value(),
            "phone" => $this->phone()->value(),
            "email" => $this->email->value()
        ];
    }
    public function update(UserName $name, UserDirection $direction, UserEmail $email, UserPassword $password, UserPhone $phone)
    {
        $this->name = $this->name()->rename($name->value());
        $this->direction = $this->direction()->update($direction->value());
        $this->email = $this->email()->update($email->value());
        $this->password = $this->password()->update($password->value());
        $this->phone = $this->phone->update($phone->value());
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
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
