<?php

namespace App\Module\Transaction\Application\GetActiveTransactionsByPharmacyAndTimePeriod;

use App\Module\Transaction\Domain\Read\PointsResponse;
use App\Module\Transaction\Domain\Read\Transaction;
use App\Module\Transaction\Domain\Read\TransactionRepository;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetActiveTransactionsByPharmacyAndTimePeriodQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TransactionRepository $repository)
    {
    }

    public function handle(GetActiveTransactionsByPharmacyAndTimePeriodQuery $query)
    {
        $list = $this->repository->getAllByPharmacyAndTimePeriod($query->pharmacyId(), $query->startDate(), $query->endDate());
        $activePoints = 0;
        /** @var Transaction $transaction */
        foreach ($list->getData() as $transaction){
            if ($transaction->getTransactionType() === TransactionType::GIVE->value) {
                $activePoints = $activePoints + $transaction->getPoints();
            } else {
                $activePoints = $activePoints - $transaction->getPoints();
            }
        }

        return PointsResponse::create($activePoints);
    }
}
