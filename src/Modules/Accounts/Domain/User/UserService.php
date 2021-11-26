<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

final class UserService
{
    public function __construct(
        private EmailAndUsernameNotExistsSpecification $alreadyExistsSpecification,
        private UserRepository $repository,
        private PasswordManager $passwordManager
    ){}

    /**
     * @throws UserException
     */
    public function register(
        string $email,
        string $username,
        string $password,
        string $firstName,
        string $lastName
    ): User {
        if (! $this->alreadyExistsSpecification->isSatisfiedBy($email, $username)) {
            throw UserException::alreadyExists();
        }

        return User::register(
            $email,
            $username,
            $this->passwordManager->hash($password),
            $firstName,
            $lastName
        );
    }

    /**
     * @throws UserException
     */
    public function signIn(string $email, string $password): User
    {
        $user = $this->repository->fetchByEmail($email) ?? throw UserException::notFoundByEmail($email);

        if (!$this->passwordManager->isValid($password, $user->getSnapshot()->getPassword())) {
            throw UserException::withInvalidCredentials();
        }

        return $user;
    }

    public function confirmEmail(): User
    {
        $user = $this->repository->fetchByConfirmToken() ?? throw UserException::notFoundByConfirmToken();

        $user->confirmEmail();

        return $user;
    }
}