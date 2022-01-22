<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetOneById;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetOneCompanyByIdAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetOneCompanyByIdRequest $request): Response
    {
        $company = $this->bus->handle(new GetOneCompanyByIdQuery($request->id));

        return GetOneCompanyByIdResponse::respond($company);
    }
}
