<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\BankAccount\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateBankAccountRequest extends Request
{
    private const NAME = 'name';
    private const BANK_NAME = 'bankName';
    private const BANK_ACCOUNT_NUMBER = 'bankAccountNumber';
    private const CURRENCY = 'currency';

    public function __construct(
        public readonly string $name,
        public readonly string $bankName,
        public readonly string $bankAccountNumber,
        public readonly string $currency,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
        $requestData = $request->toArray();
        $requestData[self::NAME] ??= null;
        $requestData[self::BANK_NAME] ??= null;
        $requestData[self::BANK_ACCOUNT_NUMBER] ??= null;
        $requestData[self::CURRENCY] ??= null;

        Assert::lazy()
            ->that($requestData[self::NAME], self::NAME)->string()->notEmpty()
            ->that($requestData[self::BANK_NAME], self::BANK_NAME)->string()->notEmpty()
            ->that($requestData[self::BANK_ACCOUNT_NUMBER], self::BANK_ACCOUNT_NUMBER)->string()->notEmpty()
            ->that($requestData[self::CURRENCY], self::CURRENCY)->string()->notEmpty()
            ->verifyNow();

        return new self(
            $requestData[self::NAME],
            $requestData[self::BANK_NAME],
            $requestData[self::BANK_ACCOUNT_NUMBER],
            $requestData[self::CURRENCY],
        );
    }
}
