<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\BankAccount;

use App\Modules\Invoices\Domain\BankAccount\BankAccount;
use App\Modules\Invoices\Domain\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Domain\BankAccount\BankAccountSnapshot;
use App\Modules\Invoices\Domain\User\UserId;
use App\Modules\Invoices\Infrastructure\Persistence\QueryBuilder\BankAccount\BankAccountQueryBuilder;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class BankAccountDbRepository implements BankAccountRepository
{
    private const DATABASE_TABLE = 'invoices_bank_accounts';

    public function __construct(private Connection $connection){}

    public function nextIdentity(): BankAccountId
    {
        return BankAccountId::generate();
    }

    /**
     * @throws Exception
     */
    public function fetchById(BankAccountId $id, UserId $userId): BankAccount
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $row = BankAccountQueryBuilder::buildSelectWithId($queryBuilder, $userId->toString(), $id->toString())
            ->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException(); // TODO: fix exception. will be throw domain
        }

        return BankAccountFactory::createFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function store(BankAccountSnapshot $snapshot): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'users_id' => ':userId',
                'invoices_companies_id' => ':companyId',
                'name' => ':name',
                'bank_name' => ':bankName',
                'bank_account_number' => ':bankAccountNumber',
                'currency_code' => ':currencyCode',
            ])
            ->setParameters([
                'id' => $snapshot->id,
                'userId' => $snapshot->userId,
                'companyId' => $snapshot->companyId,
                'name' => $snapshot->name,
                'bankName' => $snapshot->bankName,
                'bankAccountNumber' => $snapshot->bankAccountNumber,
                'currencyCode' => $snapshot->currency,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function save(BankAccountSnapshot $snapshot): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('name', ':name')
            ->set('bank_name', ':bankName')
            ->set('bank_account_number', ':bankAccountNumber')
            ->set('currency_code', ':currencyCode')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $snapshot->id,
                'userId' => $snapshot->userId,
                'name' => $snapshot->name,
                'bankName' => $snapshot->bankName,
                'bankAccountNumber' => $snapshot->bankAccountNumber,
                'currencyCode' => $snapshot->currency,
                'updatedAt' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function delete(BankAccountId $id, UserId $userId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete(self::DATABASE_TABLE)
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->executeStatement();
    }
}
