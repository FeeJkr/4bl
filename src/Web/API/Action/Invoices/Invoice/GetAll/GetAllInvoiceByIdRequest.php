<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\GetAll;

use App\Web\API\Action\Request;
use Assert\Assert;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetAllInvoiceByIdRequest extends Request
{
    private const GENERATED_AT_FILTER = 'generatedAt';

    public function __construct(public readonly ?DateTimeImmutable $generatedAtFilter){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $filter = $request->get(self::GENERATED_AT_FILTER);
        $generatedAtFilter = $filter
            ? DateTimeImmutable::createFromFormat('d-m-Y', $filter)
            : null;

        return new self($generatedAtFilter);
    }
}
