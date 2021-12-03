<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoices\Update;

use App\Web\API\Action\Request;
use Assert\Assert;
use Assert\InvalidArgumentException;
use Assert\LazyAssertionException;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

class UpdateInvoiceRequest extends Request
{
    private const ID = 'id';
	private const INVOICE_NUMBER = 'invoiceNumber';
	private const SELLER_ID = 'sellerId';
	private const BUYER_ID = 'buyerId';
	private const GENERATE_PLACE = 'generatePlace';
	private const ALREADY_TAKEN_PRICE = 'alreadyTakenPrice';
	private const GENERATE_DATE = 'generateDate';
	private const SELL_DATE = 'sellDate';
	private const CURRENCY_CODE = 'currencyCode';
	private const PRODUCTS = 'products';
    private const VAT_PERCENTAGE = 'vatPercentage';

	public function __construct(
	    private string $id,
	    private string $invoiceNumber,
        private string $sellerId,
        private string $buyerId,
        private string $generatePlace,
        private float $alreadyTakenPrice,
        private string $generateDate,
        private string $sellDate,
        private string $currencyCode,
        private array $products,
        private int $vatPercentage,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
    	$requestData = $request->toArray();
    	$id = $request->get(self::ID);
        $invoiceNumber = $requestData[self::INVOICE_NUMBER] ?? null;
        $sellerId = $requestData[self::SELLER_ID] ?? null;
        $buyerId = $requestData[self::BUYER_ID] ?? null;
        $generatePlace = $requestData[self::GENERATE_PLACE] ?? null;
        $alreadyTakenPrice = isset($requestData[self::ALREADY_TAKEN_PRICE])
            ? (float) $requestData[self::ALREADY_TAKEN_PRICE]
            : null;
        $generateDate = $requestData[self::GENERATE_DATE] ?? null;
        $sellDate = $requestData[self::SELL_DATE] ?? null;
        $currencyCode = $requestData[self::CURRENCY_CODE] ?? null;
        $products = $requestData[self::PRODUCTS] ?? null;
        $vatPercentage = isset($requestData[self::VAT_PERCENTAGE])
            ? (int) $requestData[self::VAT_PERCENTAGE]
            : null;

        Assert::lazy()
            ->that($id, self::ID)->uuid()
            ->that($invoiceNumber, self::INVOICE_NUMBER)->notEmpty()
            ->that($sellerId, self::SELLER_ID)->notEmpty()->uuid()
            ->that($buyerId, self::BUYER_ID)->notEmpty()->uuid()
            ->that($generatePlace, self::GENERATE_PLACE)->notEmpty()
            ->that($alreadyTakenPrice, self::ALREADY_TAKEN_PRICE)->float()
            ->that($generateDate, self::GENERATE_DATE)->notEmpty()->date('d-m-Y')
            ->that($sellDate, self::SELL_DATE)->notEmpty()->date('d-m-Y')
            ->that($currencyCode, self::CURRENCY_CODE)->notEmpty()
            ->that($products, self::PRODUCTS)->notEmpty()->isArray()
            ->that($vatPercentage, self::VAT_PERCENTAGE)->notNull()->integer()
            ->verifyNow();

        foreach ($products as $product) {
            if (! isset($product['name'], $product['position'], $product['price'])) {
                throw new LazyAssertionException(
                    'Products array is invalid.', [
                        new InvalidArgumentException('Products array is invalid.', 0, 'products')
                    ]
                );
            }
        }

        return new self(
            $id,
            $invoiceNumber,
            $sellerId,
            $buyerId,
            $generatePlace,
            $alreadyTakenPrice,
            $generateDate,
            $sellDate,
            $currencyCode,
            $products,
            $vatPercentage,
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    public function getBuyerId(): string
    {
        return $this->buyerId;
    }

    public function getGeneratePlace(): string
    {
        return $this->generatePlace;
    }

    public function getAlreadyTakenPrice(): float
    {
        return $this->alreadyTakenPrice;
    }

    public function getGenerateDate(): string
    {
        return $this->generateDate;
    }

    public function getSellDate(): string
    {
        return $this->sellDate;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getVatPercentage(): int
    {
        return $this->vatPercentage;
    }
}