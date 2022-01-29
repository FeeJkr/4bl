<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\BankAccount\GetOneById;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\BankAccount\GetOneById\GetOneBankAccountByIdQuery;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\Response;

final class GetOneBankAccountByIdAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetOneBankAccountByIdRequest $request): Response
    {
        $bankAccount = $this->bus->handle(
            new GetOneBankAccountByIdQuery($request->id)
        );

        return GetOneBankAccountByIdResponse::respond($bankAccount);
    }
}
