<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Domain\User;

use Exception;

final class UserService
{
    public function __construct(
        private TokenManager $tokenManager,
        private EmailAndUsernameNotExistsSpecification $alreadyExistsSpecification,
        private UserRepository $repository,
    ){}

    /**
     * @throws UserException
     */
    public function register(
        string $email,
        string $username,
        string $firstName,
        string $lastName
    ): User {
        if (! $this->alreadyExistsSpecification->isSatisfiedBy($email, $username)) {
            throw UserException::alreadyExists();
        }

        return User::register(
            $email,
            $username,
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

        $user->signIn($this->tokenManager, $password);

        $this->repository->save($user);

        return $user;
    }

    /**
     * @throws UserException
     */
    public function signOut(string $accessToken): void
    {
        $user = $this->repository->fetchByAccessToken($accessToken) ?? throw UserException::notFoundByAccessToken();

        $user->signOut();

        $this->repository->save($user);
    }

    /**
     * @throws UserException
     */
    public function refreshToken(string $accessToken): string
    {
        $user = $this->repository->fetchByAccessToken($accessToken) ?? throw UserException::notFoundByAccessToken();

        $user->refreshToken($this->tokenManager);

        $this->repository->save($user);

        return $user->getSnapshot()->getAccessToken();
    }
}