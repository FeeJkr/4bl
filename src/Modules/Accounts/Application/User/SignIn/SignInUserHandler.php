<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignIn;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Application\User\ApplicationException;
use App\Modules\Accounts\Domain\DomainException;
use App\Modules\Accounts\Domain\User\TokenRepository;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserRepository;
use App\Modules\Accounts\Domain\User\UserService;

final class SignInUserHandler implements CommandHandler
{
    public function __construct(private UserService $service) {}

    /**
     * @throws ApplicationException
     */
    public function __invoke(SignInUserCommand $command): void
    {
        try {
            $this->service->signIn($command->getEmail(), $command->getPassword());
        } catch (DomainException $exception) {
            throw ApplicationException::fromDomainException($exception);
        }
    }
}
