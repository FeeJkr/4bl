<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetAll;

use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DBALException;

class GetAllInvoicesHandler implements QueryHandler
{
    public function __construct(private Connection $connection, private UserContext $userContext){}

    /**
     * @throws DBALException
     */
    public function __invoke(GetAllInvoicesQuery $query): InvoiceDTOCollection
    {
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'i.id',
                'i.invoice_number',
                'i.generated_at',
                'i.sold_at',
                'i.currency_code',
                'seller.name as seller_name',
                'buyer.name as buyer_name',
                '(SELECT SUM(price) FROM invoices_invoice_products WHERE invoice_id = i.id) as total_price',
                'i.vat_percentage',
            )
            ->from('invoices_invoices', 'i')
            ->join('i', 'invoices_companies', 'seller', 'seller.id = i.seller_company_id')
            ->join('i', 'invoices_companies', 'buyer', 'buyer.id = i.buyer_company_id')
            ->where('i.user_id = :userId')
            ->setParameter('userId', $this->userContext->getUserId()->toString())
            ->executeQuery()
            ->fetchAllAssociative();

        $invoices = new InvoiceDTOCollection();

        foreach ($rows as $row) {
            $invoices->add(
                new InvoiceDTO(
                    $row['id'],
                    $row['invoice_number'],
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['generated_at']),
                    DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['sold_at']),
                    $row['seller_name'],
                    $row['buyer_name'],
                    (float) $row['total_price'],
                    $row['currency_code'],
                    $row['vat_percentage'],
                )
            );
        }

        return $invoices;
    }
}