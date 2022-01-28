<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateInvoiceRequest extends Request
{
    private const INVOICE_NUMBER = 'invoiceNumber';
    private const GENERATE_PLACE = 'generatePlace';
    private const ALREADY_TAKEN_PRICE = 'alreadyTakenPrice';
    private const DAYS_FOR_PAYMENT = 'daysForPayment';
    private const PAYMENT_TYPE = 'paymentType';
    private const BANK_ACCOUNT_ID = 'bankAccountId';
    private const CURRENCY_CODE = 'currencyCode';
    private const COMPANY_ID = 'companyId';
    private const CONTRACTOR_ID = 'contractorId';
    private const GENERATED_AT = 'generatedAt';
    private const SOLD_AT = 'soldAt';
    private const PRODUCTS = 'products';

    private const PRODUCT_POSITION = 'position';
    private const PRODUCT_NAME = 'name';
    private const PRODUCT_UNIT = 'unit';
    private const PRODUCT_QUANTITY = 'quantity';
    private const PRODUCT_NET_PRICE = 'netPrice';
    private const PRODUCT_TAX = 'tax';

    private const AVAILABLE_UNIT_OPTIONS = ['pieces', 'service'];
    private const AVAILABLE_TAX_OPTIONS = [0, 23];

    public function __construct(
        public readonly string $invoiceNumber,
        public readonly string $generatePlace,
        public readonly float $alreadyTakenPrice,
        public readonly int $daysForPayment,
        public readonly string $paymentType,
        public readonly ?string $bankAccountId,
        public readonly string $currencyCode,
        public readonly string $companyId,
        public readonly string $contractorId,
        public readonly string $generatedAt,
        public readonly string $soldAt,
        public readonly array $products,
    ){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();
        $invoiceNumber = $requestData[self::INVOICE_NUMBER] ?? null;
        $generatePlace = $requestData[self::GENERATE_PLACE] ?? null;
        $alreadyTakenPrice = $requestData[self::ALREADY_TAKEN_PRICE] ?? null;
        $daysForPayment = $requestData[self::DAYS_FOR_PAYMENT] ?? null;
        $paymentType = $requestData[self::PAYMENT_TYPE] ?? null;
        $bankAccountId = $requestData[self::BANK_ACCOUNT_ID] ?? null;
        $currencyCode = $requestData[self::CURRENCY_CODE] ?? null;
        $companyId = $requestData[self::COMPANY_ID] ?? null;
        $contractorId = $requestData[self::CONTRACTOR_ID] ?? null;
        $generatedAt = $requestData[self::GENERATED_AT] ?? null;
        $soldAt = $requestData[self::SOLD_AT] ?? null;
        $products = $requestData[self::PRODUCTS] ?? null;

        Assert::lazy()
            ->that($invoiceNumber, self::INVOICE_NUMBER)->string()->notEmpty()
            ->that($generatePlace, self::GENERATE_PLACE)->string()->notEmpty()
            ->that($alreadyTakenPrice, self::ALREADY_TAKEN_PRICE)->float()->notEmpty()
            ->that($daysForPayment, self::DAYS_FOR_PAYMENT)->integer()->notEmpty()
            ->that($paymentType, self::PAYMENT_TYPE)->string()->notEmpty()
            ->that($bankAccountId, self::BANK_ACCOUNT_ID)->nullOr()->uuid()
            ->that($currencyCode, self::CURRENCY_CODE)->string()->notEmpty()
            ->that($companyId, self::COMPANY_ID)->uuid()->notEmpty()
            ->that($contractorId, self::CONTRACTOR_ID)->uuid()->notEmpty()
            ->that($generatedAt, self::GENERATED_AT)->date('Y-m-d')->notEmpty()
            ->that($soldAt, self::SOLD_AT)->date('Y-m-d')->notEmpty()
            ->that($products, self::PRODUCTS)->isArray()->notEmpty()
            ->verifyNow();

        foreach ($products as $product) {
            Assert::lazy()
                ->that($product[self::PRODUCT_POSITION], self::PRODUCT_POSITION)->integer()->notEmpty()
                ->that($product[self::PRODUCT_NAME], self::PRODUCT_NAME)->string()->notEmpty()
                ->that($product[self::PRODUCT_UNIT], self::PRODUCT_UNIT)->string()->inArray(self::AVAILABLE_UNIT_OPTIONS)->notEmpty()
                ->that($product[self::PRODUCT_QUANTITY], self::PRODUCT_QUANTITY)->integer()->notEmpty()
                ->that($product[self::PRODUCT_NET_PRICE], self::PRODUCT_NET_PRICE)->float()->notEmpty()
                ->that($product[self::PRODUCT_TAX], self::PRODUCT_TAX)->integer()->inArray(self::AVAILABLE_TAX_OPTIONS)
            ->verifyNow();
        }

        return new self(
            $invoiceNumber,
            $generatePlace,
            $alreadyTakenPrice,
            $daysForPayment,
            $paymentType,
            $bankAccountId,
            $currencyCode,
            $companyId,
            $contractorId,
            $generatedAt,
            $soldAt,
            $products,
        );
    }
}
