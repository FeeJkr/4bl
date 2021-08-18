<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Domain\Invoice\Doctrine;

use App\Modules\Invoices\Domain\Invoice\Invoice;
use App\Modules\Invoices\Domain\Invoice\InvoiceId;
use App\Modules\Invoices\Domain\Invoice\InvoiceRepository as InvoiceRepositoryInterface;
use App\Modules\Invoices\Domain\User\UserId;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(private Connection $connection){}

    /**
     * @throws Throwable
     */
    public function store(Invoice $invoice): void
    {
        $this->getEntityManager()->persist($invoice);
    }

    /**
     * @throws Throwable
     */
    public function fetchAll(UserId $userId): array
    {
        return $this->findBy(['userId' => $userId]);
    }

    /**
     * @throws Throwable
     */
    public function fetchOneById(InvoiceId $invoiceId, UserId $userId): Invoice
    {
        return $this->findOneBy(['id' => $invoiceId, 'userId' => $userId]);
    }

    /**
     * @throws ORMException
     */
    public function delete(InvoiceId $invoiceId, UserId $userId): void
    {
        $invoice = $this->findOneBy(['id' => $invoiceId, 'userId' => $userId]);

        if ($invoice !== null) {
            $this->getEntityManager()->remove($invoice);
        }
    }
}