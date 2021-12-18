<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Common\Application\NotFoundException;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceParameters;
use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductId;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository as InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Exception;
use JetBrains\PhpStorm\Pure;
use Throwable;

final class InvoiceRepository implements InvoiceRepositoryInterface
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function __construct(
        private Connection $connection,
        private InvoiceProductRepository $invoiceProductRepository
    ){}

    /**
     * @throws Throwable
     */
    public function store(Invoice $invoice): void
    {
        try {
            $this->connection->beginTransaction();

            $snapshot = $invoice->getSnapshot();
            $this->connection
                ->createQueryBuilder()
                ->insert('invoices_invoices')
                ->values([
                    'id' => ':id',
                    'user_id' => ':userId',
                    'seller_company_id' => ':sellerCompanyId',
                    'buyer_company_id' => ':buyerCompanyId',
                    'invoice_number' => ':invoiceNumber',
                    'generate_place' => ':generatePlace',
                    'already_taken_price' => ':alreadyTakenPrice',
                    'currency_code' => ':currencyCode',
                    'vat_percentage' => ':vatPercentage',
                    'generated_at' => ':generatedAt',
                    'sold_at' => ':soldAt',
                ])
                ->setParameters([
                    'id' => $snapshot->id,
                    'userId' => $snapshot->userId,
                    'sellerCompanyId' => $snapshot->sellerId,
                    'buyerCompanyId' => $snapshot->buyerId,
                    'invoiceNumber' => $snapshot->parameters->invoiceNumber,
                    'generatePlace' => $snapshot->parameters->generatePlace,
                    'alreadyTakenPrice' => $snapshot->parameters->alreadyTakenPrice,
                    'currencyCode' => $snapshot->parameters->currencyCode,
                    'vatPercentage' => $snapshot->parameters->vatPercentage,
                    'generatedAt' => $snapshot->parameters->generateDate->format(self::DATETIME_FORMAT),
                    'soldAt' => $snapshot->parameters->sellDate->format(self::DATETIME_FORMAT),
                ])
                ->executeStatement();

            foreach ($snapshot->products as $product) {
                $this->invoiceProductRepository->store($snapshot->id, $product);
            }

            $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }

    /**
     * @throws Throwable
     */
    public function fetchOneById(InvoiceId $invoiceId, UserId $userId): Invoice
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'ii.id as invoice_id',
                'ii.user_id',
                'ii.seller_company_id',
                'ii.buyer_company_id',
                'ii.invoice_number',
                'ii.generate_place',
                'ii.already_taken_price',
                'ii.currency_code',
                'ii.vat_percentage',
                'ii.generated_at',
                'ii.sold_at',
                'iip.id as product_id',
                'iip.position',
                'iip.name',
                'iip.price',
            )
            ->from('invoices_invoice_products', 'iip')
            ->rightJoin('iip', 'invoices_invoices', 'ii', 'ii.id = iip.invoice_id')
            ->where('ii.id = :id')
            ->andWhere('ii.user_id = :userId')
            ->setParameters([
                'id' => $invoiceId->toString(),
                'userId' => $userId->toString(),
            ])
            ->executeQuery()
            ->fetchAllAssociative();

        if (empty($rows)) {
            throw NotFoundException::notFoundById($invoiceId->toString());
        }

        $products = $this->prepareProducts($rows);
        $row = $rows[0];

        return new Invoice(
            InvoiceId::fromString($row['invoice_id']),
            UserId::fromString($row['user_id']),
            CompanyId::fromString($row['seller_company_id']),
            CompanyId::fromString($row['buyer_company_id']),
            new InvoiceParameters(
                $row['invoice_number'],
                $row['generate_place'],
                (float) $row['already_taken_price'],
                $row['currency_code'],
                (int) $row['vat_percentage'],
                DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $row['generated_at']),
                DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $row['sold_at']),
            ),
            $products
        );
    }

    #[Pure]
    private function prepareProducts(array $rows): InvoiceProductsCollection
    {
        $products = [];

        foreach ($rows as $row) {
            if ($row['product_id'] === null) {
                return new InvoiceProductsCollection(...[]);
            }

            $products[] = new InvoiceProduct(
                InvoiceProductId::fromString($row['product_id']),
                (int) $row['position'],
                $row['name'],
                (float) $row['price'],
                (int) $row['vat_percentage'],
            );
        }

        return new InvoiceProductsCollection(...$products);
    }

    /**
     * @throws Throwable
     */
    public function delete(Invoice $invoice): void
    {
        try {
            $this->connection->beginTransaction();

            $snapshot = $invoice->getSnapshot();
            $this->connection
                ->createQueryBuilder()
                ->delete('invoices_invoice_products')
                ->where('invoice_id = :invoiceId')
                ->setParameter('invoiceId', $snapshot->id)
                ->executeStatement();

            $this->connection
                ->createQueryBuilder()
                ->delete('invoices_invoices')
                ->where('id = :id')
                ->andWhere('user_id = :userId')
                ->setParameters([
                    'id' => $snapshot->id,
                    'userId' => $snapshot->userId,
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
     * @throws ConnectionException
     * @throws Exception
     */
    public function save(Invoice $invoice): void
    {
        try {
            $this->connection->beginTransaction();

            $snapshot = $invoice->getSnapshot();
            $parametersSnapshot = $snapshot->parameters;

            $this->invoiceProductRepository->deleteByInvoiceId($snapshot->id);

            $this->connection
                ->createQueryBuilder()
                ->update('invoices_invoices')
                ->set('seller_company_id', ':sellerCompanyId')
                ->set('buyer_company_id', ':buyerCompanyId')
                ->set('invoice_number', ':invoiceNumber')
                ->set('generate_place', ':generatePlace')
                ->set('already_taken_price', ':alreadyTakenPrice')
                ->set('currency_code', ':currencyCode')
                ->set('vat_percentage', ':vatPercentage')
                ->set('generated_at', ':generatedAt')
                ->set('sold_at', ':soldAt')
                ->set('updated_at', ':updatedAt')
                ->where('id = :id')
                ->setParameters([
                    'id' => $snapshot->id,
                    'sellerCompanyId' => $snapshot->sellerId,
                    'buyerCompanyId' => $snapshot->buyerId,
                    'invoiceNumber' => $parametersSnapshot->invoiceNumber,
                    'generatePlace' => $parametersSnapshot->generatePlace,
                    'alreadyTakenPrice' => $parametersSnapshot->alreadyTakenPrice,
                    'currencyCode' => $parametersSnapshot->currencyCode,
                    'vatPercentage' => $parametersSnapshot->vatPercentage,
                    'generatedAt' => $parametersSnapshot->generateDate->format(self::DATETIME_FORMAT),
                    'soldAt' => $parametersSnapshot->sellDate->format(self::DATETIME_FORMAT),
                    'updatedAt' => (new DateTimeImmutable())->format(self::DATETIME_FORMAT),
                ])
                ->executeStatement();

            foreach ($snapshot->products as $product) {
                $this->invoiceProductRepository->store($snapshot->id, $product);
            }

            $this->connection->commit();
        } catch (Throwable $exception) {
            $this->connection->rollBack();

            throw $exception;
        }
    }
}
