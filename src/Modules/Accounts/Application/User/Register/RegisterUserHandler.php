<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\Register;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Application\User\ApplicationException;
use App\Modules\Accounts\Domain\DomainException;
use App\Modules\Accounts\Domain\User\UserRepository;
use App\Modules\Accounts\Domain\User\UserService;

final class RegisterUserHandler implements CommandHandler
{
    public function __construct(private UserService $service, private UserRepository $repository) {}

    /**
     * @throws ApplicationException
     */
    public function __invoke(RegisterUserCommand $command): void
    {
        try {
            $user = $this->service->register(
                $command->getEmail(),
                $command->getUsername(),
                $command->getFirstName(),
                $command->getLastName(),
            );

            $this->repository->store($user, $command->getPassword());
        } catch (DomainException $exception) {
            throw ApplicationException::fromDomainException($exception);
        }
    }
}
