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
        $command = new SignInUserCommand($request->getEmail(), $request->getPassword());

        /** @var HandledStamp $stamp */
        $stamp = $this->commandBus->dispatch($command)->last(HandledStamp::class);
        /** @var SignInResult $signInResult */
        $signInResult = $stamp->getResult();

        $this->requestContext->setUserIdentity($signInResult->getUser()->getId());

        return NoContentResponse::respond();
    }
}
