<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\ConfirmEmail;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository;
use App\Modules\Accounts\Domain\User\UserService;

final class ConfirmEmailHandler implements CommandHandler
{
    public function __construct(private UserService $service, private UserRepository $repository){}

    /**
     * @throws UserException
     */
    public function __invoke(ConfirmEmailCommand $command): void
    {
        $user = $this->service->confirmEmail($command->token);

        $this->repository->save($user);
    }
}
