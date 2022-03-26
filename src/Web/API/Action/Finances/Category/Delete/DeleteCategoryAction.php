<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Category\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Finances\Application\Category\Delete\DeleteCategoryCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class DeleteCategoryAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeleteCategoryRequest $request): NoContentResponse
    {
        $this->bus->dispatch(new DeleteCategoryCommand($request->id));

        return NoContentResponse::respond();
    }
}
