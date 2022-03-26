<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateCompanyRequest extends Request
{
    private const NAME = 'name';
    private const IDENTIFICATION_NUMBER = 'identificationNumber';
    private const EMAIL = 'email';
    private const PHONE_NUMBER = 'phoneNumber';
    private const IS_VAT_PAYER = 'isVatPayer';
    private const VAT_REJECTION_REASON = 'vatRejectionReason';
    private const ADDRESS = 'address';
    private const STREET = 'street';
    private const CITY = 'city';
    private const ZIP_CODE = 'zipCode';

    public function __construct(
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
        public readonly bool $isVatPayer,
        public readonly ?int $vatRejectionReason,
        public readonly string $street,
        public readonly string $city,
        public readonly string $zipCode,
    ){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();
        $name = $requestData[self::NAME] ?? null;
        $identificationNumber = $requestData[self::IDENTIFICATION_NUMBER] ?? null;
        $email = $requestData[self::EMAIL] ?? null;
        $phoneNumber = $requestData[self::PHONE_NUMBER] ?? null;
        $isVatPayer = $requestData[self::IS_VAT_PAYER] ?? null;
        $vatRejectionReason = $requestData[self::VAT_REJECTION_REASON] ?? null;
        $street = $requestData[self::ADDRESS][self::STREET] ?? null;
        $city = $requestData[self::ADDRESS][self::CITY] ?? null;
        $zipCode = $requestData[self::ADDRESS][self::ZIP_CODE] ?? null;

        $assert = Assert::lazy()
            ->that($name, self::NAME)->string()->notEmpty()
            ->that($identificationNumber, self::IDENTIFICATION_NUMBER)->string()->notEmpty()
            ->that($email, self::EMAIL)->nullOr()->email()
            ->that($phoneNumber, self::PHONE_NUMBER)->nullOr()->string()
            ->that($isVatPayer, self::IS_VAT_PAYER)->boolean()
            ->that($street, self::STREET)->string()->notEmpty()
            ->that($city, self::CITY)->string()->notEmpty()
            ->that($zipCode, self::ZIP_CODE)->string()->notEmpty();

        $isVatPayer === false
            ? $assert->that($vatRejectionReason, self::VAT_REJECTION_REASON)->integer()->notEmpty()
            : $assert->that($vatRejectionReason, self::VAT_REJECTION_REASON)->null();

        $assert->verifyNow();

        return new self(
            $name,
            $identificationNumber,
            $email,
            $phoneNumber,
            $isVatPayer,
            $vatRejectionReason,
            $street,
            $city,
            $zipCode,
        );
    }
}
