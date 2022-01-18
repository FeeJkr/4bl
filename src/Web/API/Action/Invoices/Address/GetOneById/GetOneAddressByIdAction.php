<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\GetOneById;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Address\GetOneById\GetOneByIdAddressQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetOneAddressByIdAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetOneAddressByIdRequest $request): Response
    {
        $address = $this->bus->handle(
            new GetOneByIdAddressQuery($request->id)
        );

        return GetOneAddressByIdResponse::respond($address);
    }
}
