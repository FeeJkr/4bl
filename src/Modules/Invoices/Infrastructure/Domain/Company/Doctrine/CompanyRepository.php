<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyAddress;
use App\Modules\Invoices\Domain\Company\CompanyAddressId;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Company\CompanyPaymentInformation;
use App\Modules\Invoices\Domain\Company\CompanyPaymentInformationId;
use App\Modules\Invoices\Domain\Company\CompanyRepository as CompanyRepositoryInterface;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Throwable;

final class CompanyRepository implements CompanyRepositoryInterface
{
    private const DATABASE_TABLE = 'invoices_companies';
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        private Connection $connection,
        private CompanyAddressRepository $companyAddressRepository,
        private CompanyPaymentInformationRepository $companyPaymentInformationRepository,
    ){}

    /**
     * @throws Throwable
     */
    public function fetchById(CompanyId $id, UserId $userId): ?Company
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select([
                'c.id as company_id',
                'c.user_id',
                'c.name',
                'c.identification_number',
                'c.email',
                'c.phone_number',
                'cpi.id as company_payment_information_id',
                'cpi.payment_type',
                'cpi.payment_last_day',
                'cpi.bank',
                'cpi.account_number',
                'ca.id as company_address_id',
                'ca.street',
                'ca.zip_code',
                'ca.city',
            ])
            ->from(self::DATABASE_TABLE, 'c')
            ->leftJoin('c', 'invoices_company_addresses', 'ca', 'ca.id = c.company_address_id')
            ->leftJoin('c', 'invoices_company_payment_information', 'cpi', 'cpi.id = c.company_payment_information_id')
            ->where('c.id = :id')
            ->andWhere('c.user_id = :userId')
            ->setParameters([
                'id' => $id->toString(),
                'userId' => $userId->toString(),
            ])
            ->execute()
            ->fetchAssociative();

        if ($row === false) {
            return null;
        }

        $companyAddress = new CompanyAddress(
            CompanyAddressId::fromString($row['company_address_id']),
            $row['street'],
            $row['zip_code'],
            $row['city'],
        );

        $companyPaymentInformation = $row['company_payment_information_id']
            ? new CompanyPaymentInformation(
                CompanyPaymentInformationId::fromString($row['company_payment_information_id']),
                $row['payment_type'],
                (int) $row['payment_last_day'],
                $row['bank'],
                $row['account_number'],
            )
            : null;

        return new Company(
            CompanyId::fromString($row['company_id']),
            UserId::fromString($row['user_id']),
            $companyAddress,
            $companyPaymentInformation,
            $row['name'],
            $row['identification_number'],
            $row['email'],
            $row['phone_number'],
        );
    }

    /**
     * @throws Throwable
     */
    public function store(Company $company): void
    {
        $snapshot = $company->getSnapshot();

        $this->companyAddressRepository->store($company->getAddress());

        if ($company->getPaymentInformation() !== null) {
            $this->companyPaymentInformationRepository->store($company->getPaymentInformation());
        }

        $this->connection->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'user_id' => ':userId',
                'company_address_id' => ':companyAddressId',
                'company_payment_information_id' => ':companyPaymentInformationId',
                'name' => ':name',
                'identification_number' => ':identificationNumber',
                'email' => ':email',
                'phone_number' => ':phoneNumber',
            ])
            ->setParameters([
                'id' => $snapshot->getId(),
                'userId' => $snapshot->getUserId(),
                'companyAddressId' => $snapshot->getAddressId(),
                'companyPaymentInformationId' => $snapshot->getPaymentInformationId(),
                'name' => $snapshot->getName(),
                'identificationNumber' => $snapshot->getIdentificationNumber(),
                'email' => $snapshot->getEmail(),
                'phoneNumber' => $snapshot->getPhoneNumber(),
            ])
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function delete(Company $company): void
    {
        if ($company->getPaymentInformation() !== null) {
            $this->companyPaymentInformationRepository->delete($company->getPaymentInformation());
        }

        $this->companyAddressRepository->delete($company->getAddress());

        $snapshot = $company->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->delete(self::DATABASE_TABLE)
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $snapshot->getId(),
                'userId' => $snapshot->getUserId(),
            ])
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function save(Company $company): void
    {
        if ($company->getPaymentInformation() !== null) {
            $this->companyPaymentInformationRepository->save($company->getPaymentInformation());
        }

        $this->companyAddressRepository->save($company->getAddress());

        $snapshot = $company->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('company_payment_information_id', ':companyPaymentInformationId')
            ->set('name', ':name')
            ->set('identification_number', ':identificationNumber')
            ->set('email', ':email')
            ->set('phone_number', ':phoneNumber')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->setParameters([
                'id' => $snapshot->getId(),
                'companyPaymentInformationId' => $snapshot->getPaymentInformationId(),
                'name' => $snapshot->getName(),
                'identificationNumber' => $snapshot->getIdentificationNumber(),
                'email' => $snapshot->getEmail(),
                'phoneNumber' => $snapshot->getPhoneNumber(),
                'updatedAt' => (new DateTimeImmutable())->format(self::DATETIME_FORMAT),
            ])
            ->execute();
    }
}
