<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetUserByToken;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Application\User\ApplicationException;
use App\Modules\Accounts\Domain\User\UserException;
use App\Modules\Accounts\Domain\User\UserRepository;
use Doctrine\DBAL\Exception;

final class GetUserByTokenHandler implements QueryHandler
{
    public function __construct(
        private UserRepository $userRepository,
    ){}

    /**
     * @throws ApplicationException
     */
    public function __invoke(GetUserByTokenQuery $query): UserDTO
    {
        try {
            $user = $this->userRepository->fetchByAccessToken($query->getToken());

            if ($user === null) {
                throw ApplicationException::fromDomainException(UserException::notFoundByAccessToken());
            }

            $snapshot = $user->getSnapshot();

            return new UserDTO(
                $snapshot->getId(),
                $snapshot->getEmail(),
                $snapshot->getUsername(),
                $snapshot->getFirstName(),
                $snapshot->getLastName(),
            );
        } catch (Exception) {
            throw ApplicationException::internalError();
        }
    }
}
