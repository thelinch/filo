<?php

namespace src\Shared\Infraestructure;

use Illuminate\Support\Str;
use src\Shared\Domain\CodeGenerator;

class NativeCodeGenerator implements CodeGenerator
{


    function generate(): string
    {
        $token = time() . Str::random(5);
        return $token;
    }
}
