<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Address\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateAddressRequest extends Request
{
    private const NAME = 'name';
    private const STREET = 'street';
    private const ZIP_CODE = 'zipCode';
    private const CITY = 'city';

    public function __construct(
        public readonly string $name,
        public readonly string $street,
        public readonly string $zipCode,
        public readonly string $city,
    ){}

    public static function fromRequest(ServerRequest $request): self
    {
        $requestData = $request->toArray();
        $name = $requestData[self::NAME] ?? null;
        $street = $requestData[self::STREET] ?? null;
        $zipCode = $requestData[self::ZIP_CODE] ?? null;
        $city = $requestData[self::CITY] ?? null;

        Assert::lazy()
            ->that($name, self::NAME)->string()->notEmpty()
            ->that($street, self::STREET)->string()->notEmpty()
            ->that($zipCode, self::ZIP_CODE)->string()->notEmpty()
            ->that($city, self::CITY)->string()->notEmpty()
            ->verifyNow();

        return new self(
            $name,
            $street,
            $zipCode,
            $city,
        );
    }
}
