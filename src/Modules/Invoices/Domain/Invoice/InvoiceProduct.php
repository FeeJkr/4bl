<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Invoice;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class InvoiceProduct
{
    public function __construct(private int $position, private string $name, private float $netPrice){}

    #[Pure]
    public static function fromRow(array $row): self
    {
        return new self(
            $row['product_position'],
            $row['product_name'],
            (float) $row['product_price']
        );
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNetPrice(): float
    {
        return $this->netPrice;
    }

    public function getTaxPrice(): float
    {
        return ($this->netPrice * 23) / 100;
    }

    #[Pure]
    public function getGrossPrice(): float
    {
        return $this->netPrice + $this->getTaxPrice();
    }

    #[Pure]
    #[ArrayShape(['name' => "string", 'netPrice' => "float", 'taxPrice' => "float", 'grossPrice' => "float"])]
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'netPrice' => $this->getNetPrice(),
            'taxPrice' => $this->getTaxPrice(),
            'grossPrice' => $this->getGrossPrice(),
        ];
    }
}