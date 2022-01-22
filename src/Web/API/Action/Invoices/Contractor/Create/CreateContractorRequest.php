<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Contractor\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateContractorRequest extends Request
{
    private const ADDRESS_ID = 'addressId';
    private const NAME = 'name';
    private const IDENTIFICATION_NUMBER = 'identificationNumber';

    public function __construct(
        public readonly string $addressId,
        public readonly string $name,
        public readonly string $identificationNumber,
    ){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();
        $addressId = $requestData[self::ADDRESS_ID] ?? null;
        $name = $requestData[self::NAME] ?? null;
        $identificationNumber = $requestData[self::IDENTIFICATION_NUMBER] ?? null;

        Assert::lazy()
            ->that($addressId, self::ADDRESS_ID)->uuid()->notEmpty()
            ->that($name, self::NAME)->string()->notEmpty()
            ->that($identificationNumber, self::IDENTIFICATION_NUMBER)->string()->notEmpty()
            ->verifyNow();

        return new self(
            $addressId,
            $name,
            $identificationNumber,
        );
    }
}
