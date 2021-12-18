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
	private const STREET = 'street';
	private const ZIP_CODE = 'zipCode';
	private const CITY = 'city';

	private function __construct(
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly ?string $email,
        public readonly ?string $phoneNumber,
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
    	$requestData = $request->toArray();
        $name = $requestData[self::NAME] ?? null;
        $identificationNumber = $requestData[self::IDENTIFICATION_NUMBER] ?? null;
        $email = $requestData[self::EMAIL] ?? null;
        $phoneNumber = $requestData[self::PHONE_NUMBER] ?? null;
        $street = $requestData[self::STREET] ?? null;
        $zipCode = $requestData[self::ZIP_CODE] ?? null;
        $city = $requestData[self::CITY] ?? null;

        Assert::lazy()
            ->that($name, self::NAME)->notEmpty()
            ->that($identificationNumber, self::IDENTIFICATION_NUMBER)->notEmpty()
            ->that($email, self::EMAIL)->nullOr()->email()
            ->that($phoneNumber, self::PHONE_NUMBER)->nullOr()->startsWith('+')
            ->that($street, self::STREET)->notEmpty()
            ->that($zipCode, self::ZIP_CODE)->notEmpty()
            ->that($city, self::CITY)->notEmpty()
            ->verifyNow();

        return new self(
            $name,
            $identificationNumber,
            $email,
            $phoneNumber,
            $street,
            $zipCode,
            $city
        );
    }
}
