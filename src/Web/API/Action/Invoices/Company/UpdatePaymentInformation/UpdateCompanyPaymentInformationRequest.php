<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Company\UpdatePaymentInformation;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class UpdateCompanyPaymentInformationRequest extends Request
{
	public function __construct(
		public readonly string $id,
        public readonly string $paymentType,
        public readonly int $paymentLastDate,
        public readonly string $bank,
        public readonly string $accountNumber
	){}

	public static function fromRequest(ServerRequest $request): self
	{
		$requestData = $request->toArray();
		$id = $request->get('id');
		$paymentType = $requestData['paymentType'] ?? null;
		$paymentLastDate = isset($requestData['paymentLastDate']) ? (int) $requestData['paymentLastDate'] : null;
		$bank = $requestData['bank'];
		$accountNumber = $requestData['accountNumber'];

		Assert::lazy()
			->that($id, 'id')->notEmpty()->uuid()
			->that($paymentType, 'paymentType')->notEmpty()
			->that($paymentLastDate, 'paymentLastDate')->notEmpty()->numeric()
			->that($bank, 'bank')->notEmpty()
			->that($accountNumber, 'accountNumber')->notEmpty()
			->verifyNow();

		return new self(
			$id,
			$paymentType,
			$paymentLastDate,
			$bank,
			$accountNumber
		);
	}
}
