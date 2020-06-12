<?php

namespace src\Shared\Infraestructure\Message;

use src\Shared\Domain\Message\SendingMessage;

class SendingMessageWithWatsapp implements SendingMessage
{



    public function  send(string $message): void
    {
    }
}
