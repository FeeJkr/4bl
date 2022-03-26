<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use App\Common\Application\NotFoundException;
use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\User\UserContext;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DBALException;

final class GetInvoiceByIdHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws NotFoundException
     * @throws DBALException
     */
    public function __invoke(GetInvoiceByIdQuery $query): InvoiceDTO
    {
        $row = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'users_id',
                'invoices_companies_id',
                'invoices_contractors_id',
                'invoice_number',
                'generate_place',
                'already_taken_price',
                'days_for_payment',
                'payment_type',
                'invoices_companies_bank_accounts_id',
                'currency_code',
                'generated_at',
                'sold_at',
            )
            ->from('invoices_invoices')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $query->id,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->fetchAssociative();

        if ($row === false) {
            throw NotFoundException::notFoundById($query->id);
        }

        $products = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'position',
                'name',
                'unit',
                'quantity',
                'net_price',
                'gross_price',
                'tax_percentage',
            )
            ->from('invoices_invoice_products')
            ->where('invoices_invoices_id = :invoiceId')
            ->setParameter('invoiceId', $query->id)
            ->fetchAllAssociative();

        $row['products'] = $products;

        return InvoiceDTO::fromStorage($row);
    }
}
