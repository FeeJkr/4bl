<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use App\Modules\Accounts\Domain\User\Status;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserId;
use App\Modules\Accounts\Domain\User\UserRepository as UserRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Throwable;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Throwable
     */
    public function store(User $user, string $password): void
    {
        try {
            $this->connection->beginTransaction();

            $snapshot = $user->getSnapshot();

            $this->connection
                ->createQueryBuilder()
                ->insert('accounts_users')
                ->values([
                    'id' => ':id',
                    'email' => ':email',
                    'username' => ':username',
                    'password' => ':password',
                    'first_name' => ':firstName',
                    'last_name' => ':lastName',
                    'status' => ':status'
                ])
                ->setParameters([
                    'id' => $snapshot->getId(),
                    'email' => $snapshot->getEmail(),
                    'username' => $snapshot->getUsername(),
                    'password' => $snapshot->getPassword(),
                    'firstName' => $snapshot->getFirstName(),
                    'lastName' => $snapshot->getLastName(),
                    'status' => $snapshot->getStatus(),
                ])
                ->execute();

            $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }

    public function fetchByEmail(string $email): ?User
    {
        $row = $this
            ->connection
            ->createQueryBuilder()
            ->select([
                'id',
                'email',
                'username',
                'password',
                'first_name',
                'last_name',
                'status'
            ])
            ->from('accounts_users')
            ->where('email = :email')
            ->andWhere('status = :status')
            ->setParameters([
                'email' => $email,
                'status' => Status::ACTIVE()->getValue(),
            ])
            ->execute()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return new User(
            UserId::fromString($row['id']),
            $row['email'],
            $row['username'],
            $row['password'],
            $row['first_name'],
            $row['last_name'],
            new Status($row['status']),
        );
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function fetchByAccessToken(string $accessToken): ?User
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(['id', 'email', 'username', 'password', 'first_name', 'last_name', 'status'])
            ->from('accounts_users')
            ->where('id = :id')
            ->setParameter('id', $accessToken)
            ->execute()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return new User(
            UserId::fromString($row['id']),
            $row['email'],
            $row['username'],
            $row['password'],
            $row['first_name'],
            $row['last_name'],
            new Status($row['status']),
        );
    }

    /**
     * @throws Exception
     */
    public function existsByEmailOrUsername(string $email, string $username): bool
    {
        $databaseRows = $this->connection
            ->createQueryBuilder()
            ->select(1)
            ->from('accounts_users')
            ->where('email = :email')
            ->orWhere('username = :username')
            ->setParameters([
                'email' => $email,
                'username' => $username,
            ])
            ->execute()
            ->rowCount();

        return $databaseRows > 0;
    }
}
