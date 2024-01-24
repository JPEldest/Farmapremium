<?php

namespace App\Module\Transaction\Application\CreateTransaction;

use App\Module\Transaction\Domain\Transaction;
use App\Module\Transaction\Domain\TransactionRepository;
use App\Module\Transaction\Domain\TransactionResult;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\UserRepository;
use App\Module\User\Domain\ValueObject\Balance;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Command\Result;

class CreateTransactionCommandHandler implements CommandHandlerInterface
{
    public function __construct(private TransactionRepository $transactionRepository, private UserRepository $userRepository)
    {
    }

    public function handle(CreateTransactionCommand $command)
    {
        $transaction = Transaction::create(
            $command->transactionId(),
            $command->userId(),
            $command->pharmacyId(),
            $command->points(),
            $command->transactionType(),
            $command->pointsLeft()
        );

        $this->transactionRepository->create($transaction);
        $user = $this->userRepository->ofId($command->userId());

        switch ($command->transactionType()) {
            case TransactionType::GIVE:
                $user->gatherPoints(Balance::fromInt($command->points()->asInt()));
                break;
            case TransactionType::REDEEM:
                $user->redeemPoints(Balance::fromInt($command->points()->asInt()));
                $this->transactionRepository->redeemPoints($command->points(), $command->userId());
                break;
        }

        $this->userRepository->save($user);

        return TransactionResult::success();
    }
}
