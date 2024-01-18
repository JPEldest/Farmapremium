<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Module\Transaction\Application\GetAllTransactionsByPharmacyAndTimePeriod\GetActiveTransactionsByPharmacyAndTimePeriodQuery;
use App\Shared\Infrastructure\Bus\QueryBus;
use Illuminate\Support\Facades\Date;

class GetPharmacyActivePointsController extends Controller
{
    public const FORMAT = 'dd-mm-yy';
    public function __construct(protected QueryBus $bus)
    {}

    public function getActivePoints(string $pharmacyId, string $startDay, string $endDay)
    {
        $startDate = Date::createFromFormat(self::FORMAT, $startDay);
        $endDate = Date::createFromFormat(self::FORMAT, $endDay);

        $query = GetActiveTransactionsByPharmacyAndTimePeriodQuery::create($pharmacyId, $startDate, $endDate);

        return response()->json(['response' => $this->bus->query($query)], 200);
    }

}
