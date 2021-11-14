<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\Logout;

use App\Common\Application\Command\CommandBus;
use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\SignOut\SignOutUserCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LogoutUserAction extends AbstractAction
{
    public function __construct(private CommandBus $bus, private HttpRequestContext $requestContext){}

    public function __invoke(): NoContentResponse
    {
        $this->bus->dispatch(new SignOutUserCommand($this->requestContext->getUserIdentity()));

        $this->requestContext->setUserIdentity(null);

        return NoContentResponse::respond();
    }
}