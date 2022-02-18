<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\PeriodItem\GetAll;

use App\Web\API\Action\Request;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetAllPeriodItemsRequest extends Request
{
    public function __construct(public readonly string $periodId){}

    public static function fromRequest(ServerRequest $request): Request
    {
        return new self(
            $request->get('periodId')
        );
    }
}
