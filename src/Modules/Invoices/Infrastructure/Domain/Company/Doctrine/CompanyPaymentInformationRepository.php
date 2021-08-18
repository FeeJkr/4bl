<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Company\Doctrine;

use App\Modules\Invoices\Domain\Company\CompanyPaymentInformation;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class CompanyPaymentInformationRepository
{
    private const DATABASE_TABLE = 'invoices_company_payment_information';
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function store(CompanyPaymentInformation $paymentInformation): void
    {
        $snapshot = $paymentInformation->getSnapshot();

        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'payment_type' => ':paymentType',
                'payment_last_day' => ':paymentLastDay',
                'bank' => ':bank',
                'account_number' => ':accountNumber',
            ])
            ->setParameters([
                'id' => $snapshot->getId(),
                'paymentType' => $snapshot->getPaymentType(),
                'paymentLastDay' => $snapshot->getPaymentLastDay(),
                'bank' => $snapshot->getBank(),
                'accountNumber' => $snapshot->getAccountNumber(),
            ])
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function delete(CompanyPaymentInformation $paymentInformation): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete(self::DATABASE_TABLE)
            ->where('id = :id')
            ->setParameter('id', $paymentInformation->getSnapshot()->getId())
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function save(CompanyPaymentInformation $paymentInformation): void
    {
        $snapshot = $paymentInformation->getSnapshot();

        if (!$this->existsById($snapshot->getId())) {
            $this->store($paymentInformation);

            return;
        }

        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('payment_type', ':paymentType')
            ->set('payment_last_day', ':paymentLastDay')
            ->set('bank', ':bank')
            ->set('account_number', ':accountNumber')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->setParameters([
                'id' => $snapshot->getId(),
                'paymentType' => $snapshot->getPaymentType(),
                'paymentLastDay' => $snapshot->getPaymentLastDay(),
                'bank' => $snapshot->getBank(),
                'accountNumber' => $snapshot->getAccountNumber(),
                'updatedAt' => (new DateTimeImmutable())->format(self::DATETIME_FORMAT),
            ])
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function existsById(string $id): bool
    {
        return $this->connection
            ->createQueryBuilder()
            ->select(1)
            ->from(self::DATABASE_TABLE)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->rowCount() > 0;
    }
}