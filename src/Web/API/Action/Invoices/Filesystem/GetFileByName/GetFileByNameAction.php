<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Filesystem\GetFileByName;

use App\Common\Application\Query\QueryBus;
use App\Modules\Invoices\Application\Filesystem\GetFileByName\GetFileByNameQuery;
use App\Web\API\Action\AbstractAction;

final class GetFileByNameAction extends AbstractAction
{
    public function __construct(private QueryBus $bus){}

    public function __invoke(GetFileByNameRequest $request): GetFileByNameResponse
    {
        $file = $this->bus->handle(new GetFileByNameQuery($request->filename));

        return GetFileByNameResponse::respond($file);
    }
}
