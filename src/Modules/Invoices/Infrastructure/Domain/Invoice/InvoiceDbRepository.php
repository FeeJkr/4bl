<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use App\Modules\Invoices\Domain\BankAccount\BankAccountId;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Contractor\ContractorId;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository;
use App\Modules\Invoices\Domain\Invoice\InvoiceSnapshot;
use App\Modules\Invoices\Domain\Invoice\PaymentParameters;
use App\Modules\Invoices\Domain\Invoice\PaymentType;
use App\Modules\Invoices\Domain\Invoice\Status;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class InvoiceDbRepository implements InvoiceRepository
{
    private const DATABASE_TABLE = 'invoices.invoices';

    public function __construct(
        private readonly Connection $connection,
        private readonly InvoiceProductDbRepository $invoiceProductRepository,
    ){}

    /**
     * @throws Exception
     */
    public function fetchOneById(InvoiceId $invoiceId, UserId $userId): Invoice
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'users_id',
                'companies_id',
                'contractors_id',
                'bank_accounts_id',
                'status',
                'number',
                'generate_place',
                'already_taken_price',
                'days_for_payment',
                'payment_type',
                'currency_code',
                'generated_at',
                'sold_at',
            )
            ->from(self::DATABASE_TABLE)
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $invoiceId->toString(),
                'userId' => $userId->toString(),
            ])
            ->fetchAssociative();

        if ($row === false) {
            throw new \RuntimeException();
        }

        return $this->createEntityFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function store(InvoiceSnapshot $invoice): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'users_id' => ':userId',
                'companies_id' => ':companyId',
                'contractors_id' => ':contractorId',
                'bank_accounts_id' => ':bankAccountId',
                'status' => ':status',
                'number' => ':invoiceNumber',
                'generate_place' => ':generatePlace',
                'already_taken_price' => ':alreadyTakenPrice',
                'days_for_payment' => ':daysForPayment',
                'payment_type' => ':paymentType',
                'currency_code' => ':currencyCode',
                'generated_at' => ':generatedAt',
                'sold_at' => ':soldAt',
            ])
            ->setParameters([
                'id' => $invoice->id,
                'userId' => $invoice->userId,
                'companyId' => $invoice->companyId,
                'contractorId' => $invoice->contractorId,
                'bankAccountId' => $invoice->parameters->bankAccountId,
                'status' => $invoice->status,
                'invoiceNumber' => $invoice->parameters->invoiceNumber,
                'generatePlace' => $invoice->parameters->generatePlace,
                'alreadyTakenPrice' => $invoice->parameters->alreadyTakenPrice,
                'daysForPayment' => $invoice->parameters->daysForPayment,
                'paymentType' => $invoice->parameters->paymentType,
                'currencyCode' => $invoice->parameters->currencyCode,
                'generatedAt' => $invoice->parameters->generatedAt->format('Y-m-d'),
                'soldAt' => $invoice->parameters->soldAt->format('Y-m-d'),
            ])
            ->executeStatement();

        foreach ($invoice->products as $product) {
            $this->invoiceProductRepository->store($invoice->id, $product);
        }
    }

    /**
     * @throws Exception
     */
    public function save(InvoiceSnapshot $invoice): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update(self::DATABASE_TABLE)
            ->set('companies_id', ':companyId')
            ->set('contractors_id', ':contractorId')
            ->set('bank_accounts_id', ':bankAccountId')
            ->set('status', ':status')
            ->set('number', ':invoiceNumber')
            ->set('generate_place', ':generatePlace')
            ->set('already_taken_price', ':alreadyTakenPrice')
            ->set('days_for_payment', ':daysForPayment')
            ->set('payment_type', ':paymentType')
            ->set('currency_code', ':currencyCode')
            ->set('generated_at', ':generatedAt')
            ->set('sold_at', ':soldAt')
            ->set('updated_at', ':updatedAt')
            ->where('id = :id')
            ->andWhere('users_id = :userId')
            ->setParameters([
                'id' => $invoice->id,
                'userId' => $invoice->userId,
                'companyId' => $invoice->companyId,
                'contractorId' => $invoice->contractorId,
                'bankAccountId' => $invoice->parameters->bankAccountId,
                'status' => $invoice->status,
                'invoiceNumber' => $invoice->parameters->invoiceNumber,
                'generatePlace' => $invoice->parameters->generatePlace,
                'alreadyTakenPrice' => $invoice->parameters->alreadyTakenPrice,
                'daysForPayment' => $invoice->parameters->daysForPayment,
                'paymentType' => $invoice->parameters->paymentType,
                'currencyCode' => $invoice->parameters->currencyCode,
                'generatedAt' => $invoice->parameters->generatedAt,
                'soldAt' => $invoice->parameters->soldAt,
                'updatedAt' => new DateTimeImmutable(),
            ])
            ->executeStatement();

        $this->invoiceProductRepository->deleteAllByInvoiceId($invoice->id);

        foreach ($invoice->products as $product) {
            $this->invoiceProductRepository->store($invoice->id, $product);
        }
    }

    /**
     * @throws Exception
     */
    public function delete(InvoiceId $id, UserId $userId): void
    {
        $this->invoiceProductRepository->deleteAllByInvoiceId($id->toString());

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

    /**
     * @throws Exception
     */
    private function createEntityFromRow(array $row): Invoice
    {
        return new Invoice(
            InvoiceId::fromString($row['id']),
            UserId::fromString($row['users_id']),
            CompanyId::fromString($row['companies_id']),
            ContractorId::fromString($row['contractors_id']),
            Status::from($row['status']),
            new InvoiceParameters(
                $row['number'],
                $row['generate_place'],
                (float) $row['already_taken_price'],
                new PaymentParameters(
                    (int) $row['days_for_payment'],
                    PaymentType::from($row['payment_type']),
                    BankAccountId::fromString($row['bank_accounts_id']),
                    $row['currency_code'],
                ),
                DateTimeImmutable::createFromFormat('Y-m-d', $row['generated_at']),
                DateTimeImmutable::createFromFormat('Y-m-d', $row['sold_at']),
            ),
            $this->invoiceProductRepository->fetchAllByInvoiceId($row['id']),
        );
    }
}
