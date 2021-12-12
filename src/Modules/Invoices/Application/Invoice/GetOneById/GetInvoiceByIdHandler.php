<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Invoice\GetOneById;

use App\Common\Application\NotFoundException;
use App\Common\Application\Query\QueryHandler;
use App\Modules\Invoices\Domain\User\UserContext;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Exception as DBALException;

final class GetInvoiceByIdHandler implements QueryHandler
{
    private const DATETIME_FORMAT = 'Y-m-d H:i:s';

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
                'user_id',
                'seller_company_id',
                'buyer_company_id',
                'invoice_number',
                'generate_place',
                'already_taken_price',
                'currency_code',
                'vat_percentage',
                'generated_at',
                'sold_at',
            )
            ->from('invoices_invoices')
            ->where('id = :id')
            ->andWhere('user_id = :userId')
            ->setParameters([
                'id' => $query->invoiceId,
                'userId' => $this->userContext->getUserId()->toString(),
            ])
            ->executeQuery()
            ->fetchAssociative();

        if ($row === false) {
            throw NotFoundException::notFoundById($query->invoiceId);
        }

        $products = $this->prepareInvoiceProducts($query->invoiceId);

        return new InvoiceDTO(
            $row['id'],
            $row['user_id'],
            $row['seller_company_id'],
            $row['buyer_company_id'],
            $row['invoice_number'],
            $row['generate_place'],
            (float) $row['already_taken_price'],
            $row['currency_code'],
            (int) $row['vat_percentage'],
            DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $row['generated_at']),
            DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $row['sold_at']),
            $products
        );
    }

    /**
     * @throws DBALException
     */
    private function prepareInvoiceProducts(string $invoiceId): InvoiceProductDTOCollection
    {
        $products = new InvoiceProductDTOCollection();
        $rows = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'position',
                'name',
                'price',
            )
            ->from('invoices_invoice_products')
            ->where('invoice_id = :invoiceId')
            ->setParameter('invoiceId', $invoiceId)
            ->executeQuery()
            ->fetchAllAssociative();

        foreach ($rows as $row) {
            $products->add(
                new InvoiceProductDTO(
                    $row['id'],
                    (int) $row['position'],
                    $row['name'],
                    (float) $row['price'],
                )
            );
        }

        return $products;
    }
}
