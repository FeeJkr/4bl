<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\GetOneById;

use App\Web\API\Action\Request;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class GetPeriodByIdRequest extends Request
{
    public function __construct(public readonly string $id){}

    public static function fromRequest(ServerRequest $request): Request
    {
        return new self($request->get('id'));
    }
}
