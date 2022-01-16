<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company;

use App\Modules\Invoices\Domain\Address\AddressId;
use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyRepository;
use App\Modules\Invoices\Domain\Company\CompanySnapshot;
use App\Modules\Invoices\Domain\Company\VatRejectionReason;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class CompanyDbRepository implements CompanyRepository
{
    private const DATABASE_TABLE = 'invoices_companies';

    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function fetchById(CompanyId $id, UserId $userId): Company
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'users_id',
                'invoices_addresses_id',
                'name',
                'identification_number',
                'is_vat_payer',
                'vat_rejection_reason',
                'email',
                'phone_number',
            )
            ->from(self::DATABASE_TABLE)
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException(); // TODO: FIX THIS EXCEPTION
        }

        return $this->createEntityFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function fetchByUserId(UserId $userId): Company
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'users_id',
                'invoices_addresses_id',
                'name',
                'identification_number',
                'is_vat_payer',
                'vat_rejection_reason',
                'email',
                'phone_number',
            )
            ->from(self::DATABASE_TABLE)
            ->where('users_id = :userId')
            ->setMaxResults(1)
            ->setParameters([
                'userId' => $userId->toString(),
            ])
            ->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException(); // TODO: FIX THIS EXCEPTION
        }

        return $this->createEntityFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function store(CompanySnapshot $company): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'users_id' => ':userId',
                'invoices_addresses_id' => ':addressId',
                'name' => ':name',
                'identification_number' => ':identificationNumber',
                'is_vat_payer' => ':isVatPayer',
                'vat_rejection_reason' => ':vatRejectionReason',
                'email' => ':email',
                'phone_number' => ':phoneNumber'
            ])
            ->setParameters([
                'id' => $company->id,
                'userId' => $company->userId,
                'addressId' => $company->addressId,
                'name' => $company->name,
                'identificationNumber' => $company->identificationNumber,
                'isVatPayer' => $company->isVatPayer,
                'vatRejectionReason' => $company->vatRejectionReason,
                'email' => $company->email,
                'phoneNumber' => $company->phoneNumber,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function save(CompanySnapshot $company): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('name', ':name')
            ->set('identification_number', ':identificationNumber')
            ->set('is_vat_payer', ':isVatPayer')
            ->set('vat_rejection_reason', ':vatRejectionReason')
            ->set('email', ':email')
            ->set('phone_number', ':phoneNumber')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $company->id,
                'userId' => $company->userId,
                'name' => $company->name,
                'identificationNumber' => $company->identificationNumber,
                'isVatPayer' => $company->isVatPayer,
                'vatRejectionReason' => $company->vatRejectionReason,
                'email' => $company->email,
                'phoneNumber' => $company->phoneNumber,
                'updatedAt' => new DateTimeImmutable(),
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function delete(CompanyId $id, UserId $userId): void
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

    private function createEntityFromRow(array $row): Company
    {
        return new Company(
            CompanyId::fromString($row['id']),
            UserId::fromString($row['users_id']),
            AddressId::fromString($row['invoices_addresses_id']),
            $row['name'],
            $row['identification_number'],
            (bool) $row['is_vat_payer'],
            $row['vat_rejection_reason'] ? VatRejectionReason::from($row['vat_rejection_reason']) : null,
            $row['email'],
            $row['phone_number'],
        );
    }
}
