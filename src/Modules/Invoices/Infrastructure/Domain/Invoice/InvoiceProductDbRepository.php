<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice;

use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductId;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductsCollection;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductSnapshot;
use App\Modules\Invoices\Domain\Invoice\Tax;
use App\Modules\Invoices\Domain\Invoice\Unit;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class InvoiceProductDbRepository
{
    private const DATABASE_TABLE = 'invoices_invoice_products';

    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function fetchAllByInvoiceId(string $invoiceId): InvoiceProductsCollection
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'position',
                'name',
                'unit',
                'quantity',
                'net_price',
                'tax_percentage',
            )
            ->from(self::DATABASE_TABLE)
            ->where('invoices_invoices_id = :invoiceId')
            ->setParameter('invoiceId', $invoiceId)
            ->fetchAllAssociative();

        return new InvoiceProductsCollection(
            ...array_map(fn (array $row) => $this->createEntityFromRow($row), $rows)
        );
    }

    /**
     * @throws Exception
     */
    public function store(string $invoiceId, InvoiceProductSnapshot $snapshot): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert(self::DATABASE_TABLE)
            ->values([
                'id' => ':id',
                'invoices_invoices_id' => ':invoiceId',
                'position' => ':position',
                'name' => ':name',
                'unit' => ':unit',
                'quantity' => ':quantity',
                'net_price' => ':netPrice',
                'tax_percentage' => ':taxPercentage',
            ])
            ->setParameters([
                'id' => $snapshot->id,
                'invoiceId' => $invoiceId,
                'position' => $snapshot->position,
                'name' => $snapshot->name,
                'unit' => $snapshot->unit,
                'quantity' => $snapshot->quantity,
                'netPrice' => $snapshot->netPrice,
                'taxPercentage' => $snapshot->tax,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function deleteAllByInvoiceId(string $invoiceId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete(self::DATABASE_TABLE)
            ->where('invoices_invoices_id = :invoiceId')
            ->setParameter('invoiceId', $invoiceId)
            ->executeStatement();
    }

    private function createEntityFromRow(array $row): InvoiceProduct
    {
        return new InvoiceProduct(
            InvoiceProductId::fromString($row['id']),
            (int) $row['position'],
            $row['name'],
            Unit::from($row['unit']),
            (int) $row['quantity'],
            (float) $row['net_price'],
            Tax::from((int) $row['tax_percentage']),
        );
    }
}
