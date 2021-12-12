<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Application\User\GetById;

use App\Common\Application\NotFoundException;
use App\Common\Application\Query\QueryHandler;
use App\Modules\Accounts\Application\User\UserDTO;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DBALException;
use Ramsey\Uuid\Uuid;

final class GetUserByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection){}

    /**
     * @throws NotFoundException
     * @throws DBALException
     */
    public function __invoke(GetUserByIdQuery $query): UserDTO
    {
        if (!Uuid::isValid($query->userId)) {
            throw NotFoundException::notFoundById($query->userId);
        }

        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'email',
                'username',
                'first_name',
                'last_name',
            )
            ->from('accounts_users')
            ->where('id = :id')
            ->setParameter('id', $query->userId)
            ->executeQuery()
            ->fetchAssociative();

        if ($row === false) {
            throw NotFoundException::notFoundById($query->userId);
        }

        return new UserDTO(
            $row['id'],
            $row['email'],
            $row['username'],
            $row['first_name'],
            $row['last_name'],
        );
    }
}