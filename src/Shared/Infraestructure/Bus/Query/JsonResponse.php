<?php

namespace src\Shared\Infraestructure\Bus\Query;

use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Psr\Http\Message\ResponseInterface;
use React\Promise\PromiseInterface;
use src\Shared\Domain\Bus\Query\ResponseStrategy;

class JsonResponse implements ResponseStrategy
{
    public function fromPromise(PromiseInterface $promise)
    {
        $data = null;
        $promise->done(function ($result) use ($data) {
            $data = json_encode($result);
            return $data;
        });
    }
    public function withStatus(int $statusCode)
    {
    }
}
