<?php

namespace backoffice\Categories\Application\Create;

use backoffice\Categories\Domain\CategoryId;
use backoffice\Categories\Domain\CategoryName;
use Illuminate\Support\Facades\App;
use src\Shared\Domain\Bus\Command\CommandHandler;

final class CreatePartnerCommandHandler implements CommandHandler
{

    private CategoryCreator $creator;

    public function __construct()
    {
        $this->creator = App::make();
    }
    public function handle(\Rosamarsky\CommandBus\Command $command)
    {
        $name = new CategoryName($command->name());
        $id = new CategoryId($command->id());
        $this->creator->__invoke($id, $name);
    }
}
