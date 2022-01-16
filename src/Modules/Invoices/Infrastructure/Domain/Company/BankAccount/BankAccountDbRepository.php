<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company\BankAccount;

use App\Modules\Invoices\Domain\Company\BankAccount\BankAccount;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountRepository;
use App\Modules\Invoices\Domain\Company\BankAccount\BankAccountSnapshot;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Currency;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class BankAccountDbRepository implements BankAccountRepository
{
    private const DATABASE_TABLE = 'invoices_companies_bank_accounts';

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
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'icba.id',
                'icba.invoices_companies_id',
                'icba.name',
                'icba.bank_name',
                'icba.bank_account_number',
                'icba.currency_code',
            )
            ->from(self::DATABASE_TABLE, 'icba')
            ->join('icba', 'invoices_companies', 'ic', 'ic.id = icba.invoices_companies_id')
            ->where('icba.id = :id')
            ->andWhere('ic.users_id = :userId')
            ->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException(); // TODO: fix exception. will be throw domain
        }

        return $this->createEntityFromRow($row);
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
                'invoices_companies_id' => ':companyId',
                'name' => ':name',
                'bank_name' => ':bankName',
                'bank_account_number' => ':bankAccountNumber',
                'currency_code' => ':currencyCode',
            ])
            ->setParameters([
                'id' => $snapshot->id,
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
            ->andWhere('invoices_companies_id = :companyId')
            ->setParameters([
                'id' => $snapshot->id,
                'companyId' => $snapshot->companyId,
                'name' => $snapshot->name,
                'bankName' => $snapshot->bankName,
                'bankAccountNumber' => $snapshot->bankAccountNumber,
                'currencyCode' => $snapshot->currency,
                'updated_at' => new DateTimeImmutable(),
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
            ->delete(self::DATABASE_TABLE, 'icba')
            ->join('icba', 'invoices_companies', 'ic', 'ic.id = icba.invoices_companies_id')
            ->where('icba.id = :id')
            ->andWhere('ic.users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->executeStatement();
    }

    private function createEntityFromRow(array $row): BankAccount
    {
        return new BankAccount(
            BankAccountId::fromString($row['id']),
            CompanyId::fromString($row['invoices_companies_id']),
            $row['name'],
            $row['bank_name'],
            $row['bank_account_number'],
            Currency::from($row['currency_code']),
        );
    }
}
