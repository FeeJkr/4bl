<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\SignIn;

use App\Common\Application\Command\CommandHandler;
use App\Modules\Accounts\Application\User\ApplicationException;
use App\Modules\Accounts\Application\User\UserDTO;
use App\Modules\Accounts\Domain\DomainException;
use App\Modules\Accounts\Domain\User\UserService;

final class SignInUserHandler implements CommandHandler
{
    public function __construct(private UserService $service) {}

    /**
     * @throws ApplicationException
     */
    public function __invoke(SignInUserCommand $command): SignInResult
    {
        try {
            $user = $this->service->signIn($command->getEmail(), $command->getPassword());
            $snapshot = $user->getSnapshot();

            $userDTO = new UserDTO(
                $snapshot->getId(),
                $snapshot->getEmail(),
                $snapshot->getUsername(),
                $snapshot->getFirstName(),
                $snapshot->getLastName(),
            );

            return new SignInResult($userDTO);
        } catch (DomainException $exception) {
            throw ApplicationException::fromDomainException($exception);
        }
    }
}
