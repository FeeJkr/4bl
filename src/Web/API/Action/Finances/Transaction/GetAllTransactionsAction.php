<?php
declare(strict_types=1);

namespace App\Web\API\Action\Finances\Transaction;

use App\Modules\Finances\Application\Transaction\GetAll\GetAllTransactionsQuery;
use App\Modules\Finances\Application\Transaction\GetAll\TransactionsCollection;
use App\Web\API\Action\AbstractAction;
use App\Web\API\Request\Finances\Transaction\GetAllTransactionsRequest;
use App\Web\API\Response\Finances\Transaction\TransactionsResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetAllTransactionsAction extends AbstractAction
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var TransactionsCollection $transactions */
        $transactions = $this->bus->dispatch(new GetAllTransactionsQuery())->last(HandledStamp::class)->getResult();

        $response = TransactionsResponse::createFromCollection($transactions);

        return $this->json($response->getResponse());
    }
}
