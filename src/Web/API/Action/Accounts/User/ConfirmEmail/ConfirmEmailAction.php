<?php

declare(strict_types=1);

namespace App\Web\API\Action\Accounts\User\ConfirmEmail;

use App\Common\Application\Command\CommandBus;
use App\Modules\Accounts\Application\User\ConfirmEmail\ConfirmEmailCommand;
use App\Web\API\Action\AbstractAction;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ConfirmEmailAction extends AbstractAction
{
    public function __construct(private CommandBus $bus){}

    public function __invoke(ConfirmEmailRequest $request): RedirectResponse
    {
        $this->bus->dispatch(
            new ConfirmEmailCommand($request->getToken())
        );

        return new RedirectResponse('/', Response::HTTP_FOUND);
    }
}
