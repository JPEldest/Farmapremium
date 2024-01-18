<?php

namespace App\Module\Transaction\Domain\ValueObject;

enum TransactionType: string
{
    case GIVE = 'give';
    case REDEEM = 'redeem';
}
