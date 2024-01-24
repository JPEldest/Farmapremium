<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Module\Transaction\Application\CreateTransaction\CreateTransactionCommand;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Shared\Infrastructure\Bus\CommandBus;
use Illuminate\Http\Request;

class GivePointsController extends Controller
{
    public function __construct(protected CommandBus $bus)
    {
    }

    public function givePointsTransaction(Request $request) {

        $command = CreateTransactionCommand::create($request->transactionId, $request->pharmacyId, $request->userId, $request->points, TransactionType::from($request->transactionType)->value, $request->points);

        $this->bus->dispatch($command);

        return response()->json([], 201);
    }
}
