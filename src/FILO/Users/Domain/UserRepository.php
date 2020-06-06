<?php

namespace Filo\Users\Domain;

interface UserRepository
{
    function create(User $user): void;
    function findById(UserId $id): ?User;
}
