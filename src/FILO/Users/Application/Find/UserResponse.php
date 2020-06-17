<?php

namespace Filo\Users\Application\Find;

use Filo\Users\Domain\User;
use Filo\Users\Domain\UserRole;
use JsonSerializable;

class UserResponse implements JsonSerializable
{
    private string $id;
    private string $name;
    private string $email;
    private string $phone;
    private string $direction;
    private array $roles;
    public function __construct(User $user)
    {
        $this->id = $user->id()->value();
        $this->name = $user->name()->value();
        $this->email = $user->email()->value();
        $this->phone = $user->phone()->value();
        $this->direction = $user->direction()->value();
        $this->roles = collect($user->roles())->map(fn (UserRole $role) => $role->value())->toArray();
    }
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "name" => $this->name,
            "phone" => $this->phone,
            "direction" => $this->direction,
            "roles" => $this->roles
        ];
    }
}
