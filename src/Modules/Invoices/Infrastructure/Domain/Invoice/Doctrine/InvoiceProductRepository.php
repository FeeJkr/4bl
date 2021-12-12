<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductSnapshot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

final class InvoiceProductRepository
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Exception
     */
    public function store(string $invoiceId, InvoiceProductSnapshot $snapshot): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('invoices_invoice_products')
            ->values([
                'id' => ':id',
                'invoice_id' => ':invoiceId',
                'position' => ':position',
                'name' => ':name',
                'price' => ':price',
            ])
            ->setParameters([
                'id' => $snapshot->id,
                'invoiceId' => $invoiceId,
                'position' => $snapshot->position,
                'name' => $snapshot->name,
                'price' => $snapshot->netPrice,
            ])
            ->executeStatement();
    }

    /**
     * @throws Exception
     */
    public function deleteByInvoiceId(string $invoiceId): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('invoices_invoice_products')
            ->where('invoice_id = :invoiceId')
            ->setParameter('invoiceId', $invoiceId)
            ->executeStatement();
    }
}
