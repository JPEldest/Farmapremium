<?php

namespace Tests\Unit\Module\Transaction\Domain\ValueObject;

use App\Module\Transaction\Domain\ValueObject\TransactionType;

class StubTransactionType
{
    public static function give(): TransactionType
    {
        return TransactionType::GIVE;
    }

    public static function redeem(): TransactionType
    {
        return TransactionType::REDEEM;
    }
}
