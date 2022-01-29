<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateContractorRequest extends Request
{
    private const NAME = 'name';
    private const IDENTIFICATION_NUMBER = 'identificationNumber';
    private const ADDRESS = 'address';
    private const STREET = 'street';
    private const CITY = 'city';
    private const ZIP_CODE = 'zipCode';

    public function __construct(
        public readonly string $name,
        public readonly string $identificationNumber,
        public readonly string $street,
        public readonly string $city,
        public readonly string $zipCode,
    ){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();
        $name = $requestData[self::NAME] ?? null;
        $identificationNumber = $requestData[self::IDENTIFICATION_NUMBER] ?? null;
        $street = $requestData[self::ADDRESS][self::STREET] ?? null;
        $city = $requestData[self::ADDRESS][self::CITY] ?? null;
        $zipCode = $requestData[self::ADDRESS][self::ZIP_CODE] ?? null;

        Assert::lazy()
            ->that($name, self::NAME)->string()->notEmpty()
            ->that($identificationNumber, self::IDENTIFICATION_NUMBER)->string()->notEmpty()
            ->that($street, self::STREET)->string()->notEmpty()
            ->that($city, self::CITY)->string()->notEmpty()
            ->that($zipCode, self::ZIP_CODE)->string()->notEmpty()
            ->verifyNow();

        return new self(
            $name,
            $identificationNumber,
            $street,
            $city,
            $zipCode,
        );
    }
}
