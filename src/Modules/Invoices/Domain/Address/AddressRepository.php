<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Address;

use App\Modules\Invoices\Domain\User\UserId;

interface AddressRepository
{
    public function nextIdentity(): AddressId;

    public function fetchById(AddressId $id, UserId $userId): Address;

    public function store(AddressSnapshot $address): void;
    public function save(AddressSnapshot $address): void;
    public function delete(AddressId $id, UserId $userId): void;
}
