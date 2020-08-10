<?php
declare(strict_types=1);

namespace App\Transaction\ReadModel;

use App\Category\SharedKernel\CategoryId;
use App\SharedKernel\Money;
use App\SharedKernel\User\UserId;
use App\Transaction\SharedKernel\TransactionId;
use App\Transaction\SharedKernel\TransactionType;
use App\Wallet\SharedKernel\WalletId;
use DateTime;
use DateTimeInterface;
use JsonSerializable;

final class TransactionDTO implements JsonSerializable
{
    private $id;
    private $linkedTransactionId;
    private $userId;
    private $walletId;
    private $categoryId;
    private $transactionType;
    private $amount;
    private $description;
    private $operationAt;
    private $createdAt;

    public function __construct(
        TransactionId $id,
        TransactionId $linkedTransactionId,
        UserId $userId,
        WalletId $walletId,
        CategoryId $categoryId,
        TransactionType $transactionType,
        Money $amount,
        ?string $description,
        DateTimeInterface $operationAt,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->linkedTransactionId = $linkedTransactionId;
        $this->userId = $userId;
        $this->walletId = $walletId;
        $this->categoryId = $categoryId;
        $this->transactionType = $transactionType;
        $this->amount = $amount;
        $this->description = $description;
        $this->operationAt = $operationAt;
        $this->createdAt = $createdAt;
    }

    public static function createFromArray(array $transaction): self
    {
        return new self(
            TransactionId::fromInt($transaction['id']),
            $transaction['transaction_id'] === null
                ? TransactionId::nullInstance()
                : TransactionId::fromInt($transaction['transaction_id']),
            UserId::fromInt($transaction['user_id']),
            WalletId::fromInt($transaction['wallet_id']),
            CategoryId::fromInt($transaction['category_id']),
            new TransactionType($transaction['type']),
            new Money($transaction['amount']),
            $transaction['description'],
            DateTime::createFromFormat('Y-m-d H:i:s', $transaction['operation_at']),
            DateTime::createFromFormat('Y-m-d H:i:s', $transaction['created_at'])
        );
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id->toInt(),
            'transaction_id' => $this->linkedTransactionId->isNull() ? null : $this->linkedTransactionId->toInt(),
            'user_id' => $this->userId->toInt(),
            'wallet_id' => $this->walletId->toInt(),
            'category_id' => $this->categoryId->toInt(),
            'transaction_type' => $this->transactionType->getValue(),
            'amount' => $this->amount->getAmount(),
            'description' => $this->description,
            'operation_at' => $this->operationAt->getTimestamp(),
            'created_at' => $this->operationAt->getTimestamp(),
        ];
    }
}