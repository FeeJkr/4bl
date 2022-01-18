<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Address\GetAll\GetAllAddressesQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetAllAddressesAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): Response
    {
        $addresses = $this->bus->handle(new GetAllAddressesQuery());

        return GetAllAddressesResponse::respond($addresses);
    }
}
