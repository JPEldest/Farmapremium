<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Module\Transaction\Application\GetPointsGivenToUser\GetPointsGivenToUserQuery;
use App\Shared\Infrastructure\Bus\QueryBus;

class GetPharmacyPointsToUserController extends Controller
{
    public function __construct(protected QueryBus $bus)
    {
    }

    public function getPointsGivenToUser(string $pharmacyId, string $userId)
    {
        $query = GetPointsGivenToUserQuery::create($pharmacyId, $userId);

        return response()->json(['response' => $this->bus->query($query)], 200);
    }
}
