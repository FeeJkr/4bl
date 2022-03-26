<?php

declare(strict_types=1);

namespace App\Web\API;

use Assert\InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use function array_map;

final class ValidationErrorResponse
{
    public static function getResponse(InvalidArgumentException ...$errors): array
    {
        return array_map(static fn(InvalidArgumentException $error) => [
            'propertyPath' => $error->getPropertyPath(),
            'message' => $error->getMessage(),
        ], $errors);
    }

    public static function getViolationsResponse(ConstraintViolationListInterface $violationList): array
    {
        $response = [];

        /** @var ConstraintViolationInterface $violation */
        foreach ($violationList as $violation) {
            $response[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
            ];
        }

        return $response;
    }
}
