<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Modules\Invoices\Domain\Invoice\InvoiceProduct;
use App\Modules\Invoices\Domain\Invoice\InvoiceProductSnapshot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

final class InvoiceProductRepository
{
    public function __construct(private Connection $connection){}

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
                'id' => $snapshot->getId(),
                'invoiceId' => $invoiceId,
                'position' => $snapshot->getPosition(),
                'name' => $snapshot->getName(),
                'price' => $snapshot->getNetPrice(),
            ])
            ->execute();
    }
}