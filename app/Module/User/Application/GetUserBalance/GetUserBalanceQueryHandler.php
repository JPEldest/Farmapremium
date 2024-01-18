<?php

namespace App\Module\User\Application\GetUserBalance;

use App\Module\User\Domain\Read\UserFinder;
use App\Module\User\Domain\Read\UserRepository;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Shared\Application\Query\Response;

final class GetUserBalanceQueryHandler implements QueryHandlerInterface
{
    private UserFinder $finder;

    public function __construct(UserRepository $repository)
    {
        $this->finder = new UserFinder($repository);
    }

    public function handle(GetUserBalanceQuery $query): ?Response
    {
        return $this->finder->__invoke($query->userId());
    }
}
