<?php

namespace Filo\Users\Infraestructure;

use Filo\Users\Domain\User;
use Filo\Users\Domain\UserId;
use Filo\Users\Domain\UserRepository;

class EloquentUserRepository implements UserRepository
{

    function create(User $user): void
    {
    }
    function findById(UserId $id): ?User
    {
        return null;
    }
}
