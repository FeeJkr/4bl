<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\SignIn;

use App\Common\Application\Command\CommandBus;
use App\Common\Infrastructure\Request\HttpRequestContext;
use App\Modules\Accounts\Application\User\SignIn\SignInResult;
use App\Modules\Accounts\Application\User\SignIn\SignInUserCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class SignInUserAction extends AbstractAction
{
    public function __construct(private CommandBus $commandBus, private HttpRequestContext $requestContext){}

    public function __invoke(SignInUserRequest $request): NoContentResponse
    {
        /** @var SignInResult $signInResult */
        $signInResult = $this->commandBus->dispatch(
            new SignInUserCommand($request->getEmail(), $request->getPassword())
        );

        $this->requestContext->setUserIdentity($signInResult->user->id);

        return NoContentResponse::respond();
    }
}
