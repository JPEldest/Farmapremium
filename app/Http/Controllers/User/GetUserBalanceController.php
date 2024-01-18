<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Module\User\Application\GetUserBalance\GetUserBalanceQuery;
use App\Module\User\Domain\Read\User;
use App\Shared\Infrastructure\Bus\QueryBus;

class GetUserBalanceController extends Controller
{
    public function __construct(protected QueryBus $bus)
    {
    }
    public function getBalance(string $userId)
    {
        $query = GetUserBalanceQuery::create($userId);
        /** @var User $user */
        $user = $this->bus->query($query);

        return response()->json(['response' => $user->balance()], 200);
    }
}
