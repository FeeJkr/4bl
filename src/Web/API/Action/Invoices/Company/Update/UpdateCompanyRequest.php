<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\Update;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class UpdateCompanyRequest extends Request
{
	public function __construct(
		public readonly string $companyId,
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
		$id = $request->get('id');
		$name = $requestData['name'] ?? null;
		$identificationNumber = $requestData['identificationNumber'] ?? null;
		$email = $requestData['email'] ?? null;
		$phoneNumber = $requestData['phoneNumber'] ?? null;
		$street = $requestData['street'] ?? null;
		$zipCode = $requestData['zipCode'] ?? null;
		$city = $requestData['city'] ?? null;

		Assert::lazy()
			->that($id, 'id')->notEmpty()->uuid()
			->that($name, 'name')->notEmpty()
			->that($identificationNumber, 'identificationNumber')->notEmpty()
			->that($email, 'email')->nullOr()->email()
			->that($phoneNumber, 'phoneNumber')->nullOr()->startsWith('+')
			->that($street, 'street')->notEmpty()
			->that($zipCode, 'zipCode')->notEmpty()
			->that($city, 'city')->notEmpty()
			->verifyNow();

		return new self(
			$id,
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
