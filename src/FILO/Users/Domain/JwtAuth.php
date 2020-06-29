<?php

namespace Filo\Users\Domain;






interface JwtAuth
{
    function login(string $password, string $email): array;
    public function me(): User;
    function logout();
}
