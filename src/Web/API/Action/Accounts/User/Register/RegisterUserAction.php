<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\Register;

use App\Common\Application\Command\CommandBus;
use App\Modules\Accounts\Application\User\Register\RegisterUserCommand;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Action\NoContentResponse;

final class RegisterUserAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(RegisterUserRequest $request): NoContentResponse
    {
        $this->bus->dispatch(
            new RegisterUserCommand(
                $request->email,
                $request->username,
                $request->password,
                $request->firstName,
                $request->lastName,
            )
        );

        return NoContentResponse::respond();
    }
}
