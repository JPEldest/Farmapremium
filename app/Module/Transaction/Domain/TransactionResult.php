<?php

namespace App\Module\Transaction\Domain;

use App\Shared\Application\Command\Result;

class TransactionResult extends Result
{
    public static function success(string $message = 'Command executed successfully'): self
    {
        return new self(true, 'SUCCESS_CODE', $message);
    }
}
