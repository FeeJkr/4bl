<?php
declare(strict_types=1);

namespace App\ReadModel\Category;

use App\SharedKernel\Category\CategoryId;
use App\SharedKernel\Category\CategoryType;
use App\SharedKernel\User\UserId;
use DateTimeInterface;
use JsonSerializable;

final class CategoryDTO implements JsonSerializable
{
    private $id;
    private $userId;
    private $name;
    private $type;
    private $icon;
    private $createdAt;

    public function __construct(
        CategoryId $id,
        UserId $userId,
        string $name,
        CategoryType $type,
        string $icon,
        DateTimeInterface $createdAt
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->type = $type;
        $this->icon = $icon;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id->toInt(),
            'user_id' => $this->userId->toInt(),
            'name' => $this->name,
            'type' => $this->type->getValue(),
            'icon' => $this->icon,
            'created_at' => $this->createdAt->getTimestamp(),
        ];
    }
}