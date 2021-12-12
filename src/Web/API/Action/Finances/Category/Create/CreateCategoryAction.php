<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\Create;

use App\Common\Application\Command\CommandBus;
use App\Modules\Finances\Application\Category\Create\CreateCategoryCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class CreateCategoryAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(CreateCategoryRequest $request): NoContentResponse
    {
        $command = new CreateCategoryCommand(
            $request->name,
            $request->type,
            $request->icon,
        );

        $this->bus->dispatch($command);

        return NoContentResponse::respond();
    }
}
