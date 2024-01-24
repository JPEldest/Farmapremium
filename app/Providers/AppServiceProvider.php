<?php

namespace App\Providers;

use App\Module\Transaction\Application\CreateTransaction\CreateTransactionCommand;
use App\Module\Transaction\Application\CreateTransaction\CreateTransactionCommandHandler;
use App\Module\Transaction\Application\GetActiveTransactionsByPharmacyAndTimePeriod\GetActiveTransactionsByPharmacyAndTimePeriodQuery;
use App\Module\Transaction\Application\GetActiveTransactionsByPharmacyAndTimePeriod\GetActiveTransactionsByPharmacyAndTimePeriodQueryHandler;
use App\Module\Transaction\Application\GetActiveTransactionsByPharmacyAndTimePeriod\GetAllTransactionsByPharmacyAndTimePeriodQuery;
use App\Module\Transaction\Application\GetActiveTransactionsByPharmacyAndTimePeriod\GetAllTransactionsByPharmacyAndTimePeriodQueryHandler;
use App\Module\Transaction\Application\GetPointsGivenToUser\GetPointsGivenToUserQuery;
use App\Module\Transaction\Application\GetPointsGivenToUser\GetPointsGivenToUserQueryHandler;
use App\Module\Transaction\Domain\TransactionRepository;
use App\Module\Transaction\Infrastructure\Persistence\Mysql\MysqlReadTransactionRepository;
use App\Module\Transaction\Infrastructure\Persistence\Mysql\MysqlTransactionRepository;
use App\Module\User\Application\GetUserBalance\GetUserBalanceQuery;
use App\Module\User\Application\GetUserBalance\GetUserBalanceQueryHandler;
use App\Module\User\Domain\Read\UserRepository;
use App\Module\User\Infrastructure\Persistence\Mysql\MysqlUserReadRepository;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Infrastructure\Bus\CommandBus;
use App\Shared\Infrastructure\Bus\QueryBus;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            CommandBusInterface::class,
            CommandBus::class

        );

        $this->app->singleton(
            QueryBusInterface::class,
            QueryBus::class

        );

        $this->app->singleton(
            UserRepository::class,
            MysqlUserReadRepository::class
        );

        $this->app->singleton(
            TransactionRepository::class,
            MysqlTransactionRepository::class
        );

        $this->app->singleton(
            \App\Module\Transaction\Domain\Read\TransactionRepository::class,
            MysqlReadTransactionRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $commandBus = app(CommandBusInterface::class);
        $commandBus->register([CreateTransactionCommand::class => CreateTransactionCommandHandler::class]);

        $queryBus = app(QueryBusInterface::class);
        $queryBus->register([GetUserBalanceQuery::class => GetUserBalanceQueryHandler::class]);
        $queryBus->register([GetPointsGivenToUserQuery::class => GetPointsGivenToUserQueryHandler::class]);
        $queryBus->register([GetAllTransactionsByPharmacyAndTimePeriodQuery::class => GetAllTransactionsByPharmacyAndTimePeriodQueryHandler::class]);
        $queryBus->register([GetActiveTransactionsByPharmacyAndTimePeriodQuery::class => GetActiveTransactionsByPharmacyAndTimePeriodQueryHandler::class]);
    }
}
