<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\GetAll\CompaniesCollection;
use App\Modules\Invoices\Application\Company\GetAll\GetAllCompaniesQuery;
use App\Web\API\Action\AbstractAction;

class GetAllCompaniesAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): GetAllCompaniesResponse
    {
        /** @var CompaniesCollection $companies */
        $companies = $this->bus->handle(new GetAllCompaniesQuery());

        return GetAllCompaniesResponse::respond($companies);
    }
}