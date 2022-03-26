<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\GetOneById;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Contractor\GetOneById\GetOneContractorByIdQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetOneContractorByIdAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetOneContractorByIdRequest $request): Response
    {
        $contractor = $this->bus->handle(
            new GetOneContractorByIdQuery($request->id)
        );

        return GetOneContractorByIdResponse::respond($contractor);
    }
}
