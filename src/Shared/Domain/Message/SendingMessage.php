<?php

namespace src\Shared\Domain\Message;



interface SendingMessage
{
    public function  send(string $message): void;
}
