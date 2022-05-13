<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\GetAll;

use App\Web\API\Action\Request;
use Assert\Assert;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetAllInvoiceByIdRequest extends Request
{
    private const FILTER = 'filter';

    private const GENERATED_AT_KEY = 'generatedAt';

    public function __construct(public readonly ?DateTimeImmutable $generatedAtFilter){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $filter = $request->get(self::FILTER);
        $generatedAtFilter = isset($filter[self::GENERATED_AT_KEY])
            ? DateTimeImmutable::createFromFormat('d-m-Y', $filter[self::GENERATED_AT_KEY])
            : null;

        return new self($generatedAtFilter);
    }
}
