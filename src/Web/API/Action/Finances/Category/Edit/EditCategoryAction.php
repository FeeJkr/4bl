<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\Edit;

use App\Common\Application\Command\CommandBus;
use App\Modules\Finances\Application\Category\Edit\EditCategoryCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class EditCategoryAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(EditCategoryRequest $request): NoContentResponse
    {
        $command = new EditCategoryCommand(
            $request->id,
            $request->name,
            $request->type,
            $request->icon
        );

        $this->bus->dispatch($command);

        return NoContentResponse::respond();
    }
}
