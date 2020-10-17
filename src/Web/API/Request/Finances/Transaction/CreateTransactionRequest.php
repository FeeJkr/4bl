<?php
declare(strict_types=1);

namespace App\Web\API\Request\Finances\Transaction;

use App\Modules\Finances\Domain\Transaction\TransactionType;
use App\Web\API\Request\Request;
use Assert\Assert;
use Symfony\Component\HttpFoundation\Request as ServerRequest;

final class CreateTransactionRequest extends Request
{
    private int $walletId;
    private ?int $linkedWalletId;
    private int $categoryId;
    private string $transactionType;
    private int $amount;
    private ?string $description;
    private int $operationAt;
    private string $userToken;

    public function __construct(
        int $walletId,
        ?int $linkedWalletId,
        int $categoryId,
        string $transactionType,
        int $amount,
        ?string $description,
        int $operationAt,
        string $userToken
    ) {
        $this->walletId = $walletId;
        $this->linkedWalletId = $linkedWalletId;
        $this->categoryId = $categoryId;
        $this->transactionType = $transactionType;
        $this->amount = $amount;
        $this->description = $description;
        $this->operationAt = $operationAt;
        $this->userToken = $userToken;
    }

    public static function createFromServerRequest(ServerRequest $request): self
    {
        $walletId = $request->get('wallet_id');
        $linkedWalletId = $request->get('linked_wallet_id');
        $categoryId = $request->get('category_id');
        $transactionType = $request->get('type');
        $amount = $request->get('amount');
        $description = $request->get('description');
        $operationAt = $request->get('operation_at');
        $userToken = self::extendUserTokenFromRequest($request);

        $assert = Assert::lazy()
            ->that($walletId, 'wallet_id')->notEmpty()
            ->that($categoryId, 'category_id')->notEmpty()
            ->that($transactionType, 'type')->notEmpty()
            ->that($amount, 'amount')->notEmpty()
            ->that($operationAt, 'operation_at')->notEmpty()
            ->that($userToken, 'user_token')->notEmpty();

        if ($transactionType === TransactionType::TRANSFER()->getValue()) {
            $assert = $assert->that($linkedWalletId, 'linked_wallet_id')->notEmpty();
        }

        $assert->verifyNow();

        return new self(
            (int) $walletId,
            $linkedWalletId !== null ? (int) $linkedWalletId : null,
            (int) $categoryId,
            $transactionType,
            (int) $amount,
            $description,
            (int) $operationAt,
            $userToken
        );
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getLinkedWalletId(): ?int
    {
        return $this->linkedWalletId;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getOperationAt(): int
    {
        return $this->operationAt;
    }

    public function getUserToken(): string
    {
        return $this->userToken;
    }
}
