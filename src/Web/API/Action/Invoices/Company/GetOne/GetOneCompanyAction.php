<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\GetOne;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\CompanyDTO;
use App\Modules\Invoices\Application\Company\GetOneById\GetOneCompanyByIdQuery;
use App\Web\API\Action\AbstractAction;

final class GetOneCompanyAction extends AbstractAction
{
	public function __construct(private QueryBus $bus){}

	public function __invoke(GetOneCompanyRequest $request): GetOneCompanyResponse
	{
		/** @var CompanyDTO $companyDTO */
		$companyDTO = $this->bus->handle(new GetOneCompanyByIdQuery($request->companyId));

		return GetOneCompanyResponse::respond($companyDTO);
	}
}
