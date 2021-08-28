<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Request;

interface HttpRequestContext
{
    public function getUserIdentity(): string;
    public function setUserIdentity(mixed $identity): void;
}
