<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Module\Transaction\Application\CreateTransaction\CreateTransactionCommand;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Shared\Infrastructure\Bus\CommandBus;

class GivePointsController extends Controller
{
    public function __construct(protected CommandBus $bus)
    {
    }

    public function givePointsTransaction(
        string $transactionId,
        string $pharmacyId,
        string $userId,
        int $points
    ) {
        $command = CreateTransactionCommand::create($transactionId, $pharmacyId, $userId, $points, TransactionType::GIVE->value, $points);

        $this->bus->dispatch($command);

        return response()->json([], 200);
    }
}
