<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Infrastructure\Domain\User\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Exception;
use Throwable;

class UserConfirmationRepository
{
    public function __construct(private Connection $connection){}

    /**
     * @throws ConnectionException
     * @throws Throwable
     * @throws Exception
     */
    public function generate(string $userId, string $email, string $confirmationToken): void
    {
        try {
            $this->connection->beginTransaction();

            $this->connection
                ->createQueryBuilder()
                ->insert('accounts_users_confirmation')
                ->values([
                    'user_id' => ':userId',
                    'email' => ':email',
                    'confirmation_token' => ':confirmationToken',
                ])
                ->setParameters([
                    'userId' => $userId,
                    'email' => $email,
                    'confirmationToken' => $confirmationToken,
                ])
                ->execute();

            $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}