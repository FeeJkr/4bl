<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

class CreateCompanyRequest extends Request
{
	private const NAME = 'name';
	private const IDENTIFICATION_NUMBER = 'identificationNumber';
	private const EMAIL = 'email';
	private const PHONE_NUMBER = 'phone_number';
	private const STREET = 'street';
	private const ZIP_CODE = 'zipCode';
	private const CITY = 'city';

	private function __construct(
        private string $name,
        private string $identificationNumber,
        private ?string $email,
        private ?string $phoneNumber,
        private string $street,
        private string $zipCode,
        private string $city,
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdentificationNumber(): string
    {
        return $this->identificationNumber;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }
}