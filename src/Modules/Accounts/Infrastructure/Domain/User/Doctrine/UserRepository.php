<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use App\Modules\Accounts\Domain\User\Status;
use App\Modules\Accounts\Domain\User\User;
use App\Modules\Accounts\Domain\User\UserRepository as UserRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Throwable;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly Connection $connection){}

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
                ->insert('accounts.users')
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
                    'id' => $snapshot->id,
                    'email' => $snapshot->email,
                    'username' => $snapshot->username,
                    'password' => $snapshot->password,
                    'firstName' => $snapshot->firstName,
                    'lastName' => $snapshot->lastName,
                    'status' => $snapshot->status,
                ])
                ->executeStatement();

            $this->connection
                ->createQueryBuilder()
                ->insert('accounts.users_confirmation')
                ->values([
                    'users_id' => ':userId',
                    'email' => ':email',
                    'confirmation_token' => ':confirmationToken',
                ])
                ->setParameters([
                    'userId' => $snapshot->id,
                    'email' => $snapshot->email,
                    'confirmationToken' => $snapshot->confirmationToken,
                ])
                ->executeStatement();

            $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }

    /**
     * @throws Throwable
     */
    public function save(User $user): void
    {
        try {
            $this->connection->beginTransaction();

            $snapshot = $user->getSnapshot();

            $this->connection
                ->createQueryBuilder()
                ->update('accounts.users')
                ->set('status', ':status')
                ->setParameters([
                    'status' => $snapshot->status,
                ])
                ->executeStatement();

            $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }

    /**
     * @throws Exception
     */
    public function fetchByEmail(string $email): ?User
    {
        $row = $this
            ->connection
            ->createQueryBuilder()
            ->select(
                'u.id',
                'u.email',
                'u.username',
                'u.password',
                'u.first_name',
                'u.last_name',
                'u.status',
                'uc.confirmation_token'
            )
            ->from('accounts.users', 'u')
            ->leftJoin('u', 'accounts.users_confirmation', 'uc', 'uc.users_id = u.id')
            ->where('u.email = :email')
            ->andWhere('u.status = :status')
            ->setParameters([
                'email' => $email,
                'status' => Status::ACTIVE->value,
            ])
            ->executeQuery()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return UserFactory::fromRow($row);
    }

    /**
     * @throws Exception
     */
    public function existsByEmailOrUsername(string $email, string $username): bool
    {
        $databaseRows = $this->connection
            ->createQueryBuilder()
            ->select(1)
            ->from('accounts.users')
            ->where('email = :email')
            ->orWhere('username = :username')
            ->setParameters([
                'email' => $email,
                'username' => $username,
            ])
            ->executeQuery()
            ->rowCount();

        return $databaseRows > 0;
    }

    /**
     * @throws Exception
     */
    public function fetchByConfirmToken(string $confirmToken): ?User
    {
        $row = $this
            ->connection
            ->createQueryBuilder()
            ->select(
                'u.id',
                'u.email',
                'u.username',
                'u.password',
                'u.first_name',
                'u.last_name',
                'u.status',
                'uc.confirmation_token'
            )
            ->from('accounts.users', 'u')
            ->leftJoin('u', 'accounts.users_confirmation', 'uc', 'uc.users_id = u.id')
            ->where('uc.confirmation_token = :confirmationToken')
            ->andWhere('u.status = :status')
            ->andWhere('uc.email = u.email')
            ->setParameters([
                'confirmationToken' => $confirmToken,
                'status' => Status::EMAIL_VERIFICATION->value,
            ])
            ->executeQuery()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return UserFactory::fromRow($row);
    }
}
