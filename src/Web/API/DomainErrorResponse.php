<?php

declare(strict_types=1);

namespace App\Web\API;

use JetBrains\PhpStorm\ArrayShape;
use Throwable;

final class DomainErrorResponse
{
	#[ArrayShape(['message' => "string"])]
	public static function getResponse(Throwable $exception): array
    {
    	return [
			[
				'message' => $exception->getMessage(),
			],
		];
    }
}
