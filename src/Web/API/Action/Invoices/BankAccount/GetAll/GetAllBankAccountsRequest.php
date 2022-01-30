<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\BankAccount\GetAll;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetAllBankAccountsRequest extends Request
{
    private const COMPANY_ID = 'companyId';

    public function __construct(public readonly string $companyId){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $companyId = $request->get(self::COMPANY_ID);

        Assert::lazy()
            ->that($companyId, self::COMPANY_ID)->uuid()->notEmpty()
            ->verifyNow();

        return new self($companyId);
    }
}
