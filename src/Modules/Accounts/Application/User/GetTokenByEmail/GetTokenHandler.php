<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetTokenByEmail;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Application\User\ApplicationException;
use App\Modules\Accounts\Domain\User\UserException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Exception as DBALException;

final class GetTokenHandler implements QueryHandler
{
    public function __construct(private Connection $connection) {}

    /**
     * @throws ApplicationException
     */
    public function __invoke(GetTokenQuery $query): TokenDTO
    {
        try {
            $row = $this->connection
                ->createQueryBuilder()
                ->select('access_token')
                ->from('accounts_users')
                ->where('email = :email')
                ->setParameter('email', $query->getEmail())
                ->execute()
                ->fetchAssociative();

            if ($row === false || ! isset($row['access_token'])) {
                throw ApplicationException::fromDomainException(UserException::withInvalidCredentials());
            }

            return new TokenDTO($row['access_token']);
        } catch (DBALException|Exception) {
            throw ApplicationException::internalError();
        }
    }
}
