<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use ContainerGjyRmHi\getDropboxService;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateCompanyRequest extends Request
{
    private const NAME = 'name';
    private const IDENTIFICATION_NUMBER = 'identificationNumber';
    private const ADDRESS_ID = 'addressId';
    private const EMAIL = 'email';
    private const PHONE_NUMBER = 'phoneNumber';
    private const IS_VAT_PAYER = 'isVatPayer';
    private const REASON = 'reason';

    public function __construct(
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly string $addressId,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
        public readonly bool $isVatPayer,
        public readonly ?int $reason,
    ){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();
        $name = $requestData[self::NAME] ?? null;
        $identificationNumber = $requestData[self::IDENTIFICATION_NUMBER] ?? null;
        $addressId = $requestData[self::ADDRESS_ID] ?? null;
        $email = $requestData[self::EMAIL] ?? null;
        $phoneNumber = $requestData[self::PHONE_NUMBER] ?? null;
        $isVatPayer = $requestData[self::IS_VAT_PAYER] ?? null;
        $reason = $requestData[self::REASON] ?? null;

        Assert::lazy()
            ->that($name, self::NAME)->string()->notEmpty()
            ->that($identificationNumber, self::IDENTIFICATION_NUMBER)->string()->notEmpty()
            ->that($addressId, self::ADDRESS_ID)->uuid()->notEmpty()
            ->that($email, self::EMAIL)->nullOr()->email()
            ->that($phoneNumber, self::PHONE_NUMBER)->nullOr()->string()
            ->that($isVatPayer, self::IS_VAT_PAYER)->boolean()
            ->that($reason, self::REASON)->nullOr()->integer()
            ->verifyNow();

        return new self(
            $name,
            $identificationNumber,
            $addressId,
            $email,
            $phoneNumber,
            $isVatPayer,
            $reason,
        );
    }
}
