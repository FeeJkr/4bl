<?php

declare(strict_types=1);

namespace App\Web\API\Action\Invoices\Invoice\GetAll;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetAllInvoiceByIdRequest extends Request
{
    private const FILTER = 'filter';

    private const GENERATED_AT_KEY = 'generatedAt';

    public function __construct(public readonly array $generatedAtFilter = []){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $filter = $request->get(self::FILTER);

        if (isset($filter[self::GENERATED_AT_KEY])) {
            return new self(
                $filter[self::GENERATED_AT_KEY]
            );
        }

        return new self();
    }
}
