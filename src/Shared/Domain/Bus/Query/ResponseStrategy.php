<?php

namespace src\Shared\Domain\Bus\Query;

use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;

interface ResponseStrategy
{
    public function fromPromise(PromiseInterface $promise);
    public function withStatus(int $statusCode);
}
