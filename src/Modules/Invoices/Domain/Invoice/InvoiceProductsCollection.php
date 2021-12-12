<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

class InvoiceProductsCollection
{
    private array $products;

    public function __construct(InvoiceProduct ...$products)
    {
        $this->products = $products;
    }

    public function toArray(): array
    {
        return $this->products;
    }

    public static function fromArray(array $products, int $vatPercentage): self
    {
        $mappedProducts = array_map(
            static fn(array $product): InvoiceProduct => new InvoiceProduct(
                InvoiceProductId::generate(),
                (int) $product['position'],
                $product['name'],
                (float) $product['price'],
                $vatPercentage,
            ),
            $products
        );

        return new self(...$mappedProducts);
    }
}
