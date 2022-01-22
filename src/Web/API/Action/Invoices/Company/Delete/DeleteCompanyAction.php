<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Delete;

use App\Common\Application\Command\CommandBus;
use App\Modules\Invoices\Application\Company\Delete\DeleteCompanyCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use App\Web\API\Action\Response;

final class DeleteCompanyAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(DeleteCompanyRequest $request): Response
    {
        $this->bus->dispatch(new DeleteCompanyCommand($request->id));

        return NoContentResponse::respond();
    }
}
