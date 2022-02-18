<?php

declare(strict_types=1);

namespace App\Web\API\Action\FinancesGraph\Period\Create;

use App\Web\API\Action\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreatePeriodRequest extends Request
{
    private const NAME = 'name';
    private const START_AT = 'startAt';
    private const END_AT = 'endAt';
    private const START_BALANCE = 'startBalance';

    private const PLANNED_MANDATORY_EXPENSES = 'plannedMandatoryExpenses';
    private const PLANNED_MANDATORY_EXPENSES_DATE = 'date';
    private const PLANNED_MANDATORY_EXPENSES_AMOUNT = 'amount';

    private const CATEGORIES = 'categories';
    private const CATEGORIES_NAME = 'name';
    private const CATEGORIES_BALANCE = 'balance';
    private const CATEGORIES_IS_MANDATORY = 'isMandatory';

    public function __construct(
        public readonly string $name,
        public readonly string $startAt,
        public readonly string $endAt,
        public readonly float $startBalance,
        public readonly array $plannedMandatoryExpenses,
        public readonly array $categories,
    ){}

    public static function fromRequest(ServerRequest $request): Request
    {
        $requestData = $request->toArray();
        $name = $requestData[self::NAME] ?? null;
        $startAt = $requestData[self::START_AT] ?? null;
        $endAt = $requestData[self::END_AT] ?? null;
        $startBalance = isset($requestData[self::START_BALANCE]) ? (float) $requestData[self::START_BALANCE] : null;

        $validation = Assert::lazy()
            ->that($name, self::NAME)->string()->notEmpty()
            ->that($startAt, self::START_AT)->date('Y-m-d')
            ->that($endAt, self::END_AT)->date('Y-m-d')
            ->that($startBalance, self::START_BALANCE)->float();

        foreach ($requestData[self::PLANNED_MANDATORY_EXPENSES] as $expense) {
            $validation
                ->that($expense[self::PLANNED_MANDATORY_EXPENSES_DATE], self::PLANNED_MANDATORY_EXPENSES_DATE)->date('Y-m-d')
                ->that((float) $expense[self::PLANNED_MANDATORY_EXPENSES_AMOUNT], self::PLANNED_MANDATORY_EXPENSES_AMOUNT);
        }

        foreach ($requestData[self::CATEGORIES] as $category) {
            $validation
                ->that($category[self::CATEGORIES_NAME], self::CATEGORIES_NAME)->string()->notEmpty()
                ->that($category[self::CATEGORIES_BALANCE], self::CATEGORIES_BALANCE)->float()
                ->that($category[self::CATEGORIES_IS_MANDATORY], self::CATEGORIES_IS_MANDATORY)->boolean();
        }

        $validation->verifyNow();

        return new self(
            $name,
            $startAt,
            $endAt,
            $startBalance,
            $requestData[self::PLANNED_MANDATORY_EXPENSES],
            $requestData[self::CATEGORIES],
        );
    }
}
