<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\BankAccount\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Company\BankAccount\GetAll\GetAllBankAccountsQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetAllBankAccountsAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): Response
    {
        $bankAccounts = $this->bus->handle(new GetAllBankAccountsQuery());

        return GetAllBankAccountsResponse::respond($bankAccounts);
    }
}
