<?php

namespace App\Module\Transaction\Application\GetAllTransactionsByPharmacyAndTimePeriod;

use App\Module\Transaction\Domain\Read\TransactionRepository;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetAllTransactionsByPharmacyAndTimePeriodQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TransactionRepository $repository)
    {
    }

    public function handle(GetAllTransactionsByPharmacyAndTimePeriodQuery $query)
    {
        return $this->repository->getAllByPharmacyAndTimePeriod($query->pharmacyId(), $query->startDate(), $query->endDate());
    }

}
