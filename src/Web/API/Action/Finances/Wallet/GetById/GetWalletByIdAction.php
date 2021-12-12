<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\GetById;

use App\Common\Application\Query\QueryBus;
use App\Modules\Finances\Application\Wallet\GetById\GetWalletByIdQuery;
use App\Web\API\Action\AbstractAction;

final class GetWalletByIdAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetWalletByIdRequest $request): GetWalletByIdResponse
    {
        $wallet = $this->bus->handle(
            new GetWalletByIdQuery($request->id)
        );

        return GetWalletByIdResponse::respond($wallet);
    }
}
