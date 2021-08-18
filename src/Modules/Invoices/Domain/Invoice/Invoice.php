<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use App\Modules\Invoices\Domain\Company\Company;
use App\Modules\Invoices\Domain\Company\CompanyId;
use App\Modules\Invoices\Domain\User\UserId;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Invoice
{
    public function __construct(
        private InvoiceId $id,
        private UserId $userId,
        private CompanyId $sellerId,
        private CompanyId $buyerId,
        private InvoiceParameters $parameters,
        private array $products,
    ){}

    public static function create(
        UserId $userId,
        CompanyId $sellerId,
        CompanyId $buyerId,
        InvoiceParameters $parameters,
        array $products,
    ): self {
        return new self(
            InvoiceId::generate(),
            $userId,
            $sellerId,
            $buyerId,
            $parameters,
            self::prepareProducts($products),
        );
    }

    private static function prepareProducts(array $products): array
    {
        $productsCollection = [];

        foreach ($products as $product) {
            $productsCollection[] =
                new InvoiceProduct(
                    InvoiceProductId::generate(),
                    (int) $product['position'],
                    $product['name'],
                    (float) $product['price'],
                );
        }

        return $productsCollection;
    }

    public function update(
        Company $seller,
        Company $buyer,
        InvoiceParameters $parameters,
        array $products,
    ): void {
        $this->seller = $seller;
        $this->buyer = $buyer;
        $this->parameters = $parameters;
        $this->setProducts($products);
    }

    public function getId(): InvoiceId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getSellerId(): CompanyId
    {
        return $this->sellerId;
    }

    public function getBuyerId(): CompanyId
    {
        return $this->buyerId;
    }

    public function getParameters(): InvoiceParameters
    {
        return $this->parameters;
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}