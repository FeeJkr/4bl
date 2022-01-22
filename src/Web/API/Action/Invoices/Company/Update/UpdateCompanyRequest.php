<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Update;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class UpdateCompanyRequest extends Request
{
    private const ID = 'id';
    private const NAME = 'name';
    private const IDENTIFICATION_NUMBER = 'identificationNumber';
    private const EMAIL = 'email';
    private const PHONE_NUMBER = 'phoneNumber';
    private const IS_VAT_PAYER = 'isVatPayer';
    private const REASON = 'reason';

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
        public readonly bool $isVatPayer,
        public readonly ?int $reason,
    ){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();
        $id = $request->get(self::ID);
        $name = $requestData[self::NAME] ?? null;
        $identificationNumber = $requestData[self::IDENTIFICATION_NUMBER] ?? null;
        $email = $requestData[self::EMAIL] ?? null;
        $phoneNumber = $requestData[self::PHONE_NUMBER] ?? null;
        $isVatPayer = $requestData[self::IS_VAT_PAYER] ?? null;
        $reason = $requestData[self::REASON] ?? null;

        Assert::lazy()
            ->that($id, self::ID)->uuid()->notEmpty()
            ->that($name, self::NAME)->string()->notEmpty()
            ->that($identificationNumber, self::IDENTIFICATION_NUMBER)->string()->notEmpty()
            ->that($email, self::EMAIL)->nullOr()->email()
            ->that($phoneNumber, self::PHONE_NUMBER)->nullOr()->string()
            ->that($isVatPayer, self::IS_VAT_PAYER)->boolean()
            ->that($reason, self::REASON)->nullOr()->integer()
            ->verifyNow();

        return new self(
            $id,
            $name,
            $identificationNumber,
            $email,
            $phoneNumber,
            $isVatPayer,
            $reason,
        );
    }
}
