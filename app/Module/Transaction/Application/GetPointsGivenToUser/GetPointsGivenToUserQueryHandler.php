<?php

namespace App\Module\Transaction\Application\GetPointsGivenToUser;

use App\Module\Transaction\Domain\Read\TransactionRepository;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetPointsGivenToUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(private TransactionRepository $repository)
    {
    }

    public function handle(GetPointsGivenToUserQuery $query)
    {
        $list = $this->repository->getTransactionsByPharmacyUserAndType($query->pharmacyId(), $query->userId(), TransactionType::GIVE);
    }
}
