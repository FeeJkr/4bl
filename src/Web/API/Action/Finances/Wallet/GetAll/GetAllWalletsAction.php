<?php

declare(strict_types=1);

namespace App\Web\API\Action\Finances\Wallet\GetAll;

use App\Common\Application\Query\QueryBus;
use App\Modules\Finances\Application\Wallet\GetAll\GetAllWalletsQuery;
use App\Web\API\Action\AbstractAction;

final class GetAllWalletsAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(): GetAllWalletsResponse
    {
        $wallets = $this->bus->handle(new GetAllWalletsQuery());

        return GetAllWalletsResponse::respond($wallets);
    }
}
