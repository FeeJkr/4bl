<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\GetMyUserData;

use App\Common\Application\Query\QueryBus;
use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\GetById\GetUserByIdQuery;
use App\Modules\Accounts\Application\User\UserDTO;
use App\Web\API\Action\AbstractAction;

final class GetMyUserDataAction extends AbstractAction
{
    public function __construct(private QueryBus $bus, private HttpRequestContext $requestContext){}

    public function __invoke(): GetMyUserDataResponse
    {
        /** @var UserDTO $user */
        $user = $this->bus->handle(
            new GetUserByIdQuery($this->requestContext->getUserIdentity())
        );

        return GetMyUserDataResponse::respond($user);
    }
}
