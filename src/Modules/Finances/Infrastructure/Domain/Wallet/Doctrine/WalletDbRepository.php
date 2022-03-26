<?php

declare(strict_types=1);

namespace App\Modules\Finances\Infrastructure\Domain\Wallet\Doctrine;

use App\Modules\Finances\Domain\Currency;
use App\Modules\Finances\Domain\Money;
use App\Modules\Finances\Domain\User\UserId;
use App\Modules\Finances\Domain\Wallet\Wallet;
use App\Modules\Finances\Domain\Wallet\WalletId;
use App\Modules\Finances\Domain\Wallet\WalletRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class WalletDbRepository implements WalletRepository
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function store(Wallet $wallet): void
    {
        $snapshot = $wallet->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->insert('wallets')
            ->values([
                'id' => ':id',
                'user_id' => ':userId',
                'name' => ':name',
                'start_balance' => ':startBalance',
                'currency' => ':currency',
            ])
            ->setParameters([
                'id' => $snapshot->id,
                'userId' => $snapshot->userId,
                'name' => $snapshot->name,
                'startBalance' => $snapshot->startBalance,
                'currency' => $snapshot->currency,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function delete(WalletId $id, UserId $userId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('wallets')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function getById(WalletId $id, UserId $userId): Wallet
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'user_id',
                'name',
                'start_balance',
                'currency',
            )
            ->from('wallets')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([])
            ->executeQuery()
            ->fetchAssociative();

        return new Wallet(
            WalletId::fromString($row['id']),
            UserId::fromString($row['user_id']),
            $row['name'],
            new Money(
                (int) $row['start_balance'],
                Currency::from($row['currency']),
            )
        );
    }

    /**
     * @throws Exception
     */
    public function save(Wallet $wallet): void
    {
        $snapshot = $wallet->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->update('wallets')
            ->set('name', ':name')
            ->set('start_balance', ':startBalance')
            ->set('currency', ':currency')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $snapshot->id,
                'user_id' => $snapshot->userId,
                'name' => $snapshot->name,
                'startBalance' => $snapshot->startBalance,
                'currency' => $snapshot->currency,
            ])
            ->executeStatement();
    }
}
