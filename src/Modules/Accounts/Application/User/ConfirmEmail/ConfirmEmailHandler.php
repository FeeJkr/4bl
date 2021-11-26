<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\ConfirmEmail;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Domain\User\UserRepository;
use App\Modules\Accounts\Domain\User\UserService;

class ConfirmEmailHandler implements CommandHandler
{
    public function __construct(private UserService $service, private UserRepository $repository){}

    public function __invoke(ConfirmEmailCommand $command): void
    {
        $this->service->confirmEmail($command->getToken());
    }
}