<?php

namespace Filo\Users\Domain;

interface UserRepositoryI
{
    function create(User $user): void;
    function findById(UserId $id): ?User;
    function update(User $user): void;
    function delete(User $user): void;
}
