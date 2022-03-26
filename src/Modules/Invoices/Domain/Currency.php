<?php

namespace App\Modules\Invoices\Domain;

enum Currency : string
{
    case PLN = 'pln';
    case USD = 'usd';
}
