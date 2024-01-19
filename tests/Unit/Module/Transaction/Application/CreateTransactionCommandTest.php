<?php

namespace Tests\Unit\Module\Transaction\Application;

use App\Module\Transaction\Application\CreateTransaction\CreateTransactionCommand;
use App\Module\Transaction\Application\CreateTransaction\CreateTransactionCommandHandler;
use App\Module\Transaction\Domain\ValueObject\Points;
use App\Module\Transaction\Domain\ValueObject\TransactionId;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\ValueObject\Balance;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Module\Transaction\Domain\InMemoryTransactionsRepository;
use Tests\Unit\Module\Transaction\Domain\StubTransactionBuilder;
use Tests\Unit\Module\User\Domain\InMemoryWriteUserRepository;
use Tests\Unit\Module\User\Domain\StubUserBuilder;

class CreateTransactionCommandTest extends TestCase
{
    protected function setUp(): void
    {
        $this->transactionsRepository = new InMemoryTransactionsRepository();
        $this->usersRepository = new InMemoryWriteUserRepository();
        $this->createTransactionCommandHandler = new CreateTransactionCommandHandler($this->transactionsRepository, $this->usersRepository);
        parent::setUp();
    }

    /**
     * @test
     */
    public function should_create_redeem_transaction()
    {
        $startingBalance = Balance::fromInt(100);
        $user = StubUserBuilder::create()->withBalance($startingBalance)->build();
        $this->usersRepository->save($user);
        $giveOne = StubTransactionBuilder::create()
            ->withTransactionType(TransactionType::GIVE)
            ->withUserId($user->id())
            ->withPoints(Points::fromInt(20))
            ->build();
        $this->transactionsRepository->save($giveOne);
        $giveTwo = StubTransactionBuilder::create()
            ->withTransactionType(TransactionType::GIVE)
            ->withUserId($user->id())
            ->withPoints(Points::fromInt(30))
            ->build();
        $this->transactionsRepository->save($giveTwo);

        $redeem = StubTransactionBuilder::create()
            ->withTransactionType(TransactionType::REDEEM)
            ->withUserId($user->id())
            ->withPoints(Points::fromInt(40))
            ->build();

        $command = CreateTransactionCommand::create(
            $redeem->id()->asString(),
            $redeem->pharmacyId()->asString(),
            $redeem->userId()->asString(),
            $redeem->points()->asInt(),
            $redeem->transactionType()->value,
            $redeem->pointsLeft()->asInt()
        );

        $this->createTransactionCommandHandler->handle($command);
        $afterUser = $this->usersRepository->ofId($user->id());

        $remainingPoints = $giveTwo->points()->asInt() -($redeem->points()->asInt() - $giveOne->points()->asInt());

        self::assertEquals($startingBalance->asInt(), $redeem->points()->asInt()+$afterUser->balance()->asInt());
        self::assertEquals(0, $giveOne->pointsLeft()->asInt());
        self::assertEquals($remainingPoints, $giveTwo->pointsLeft()->asInt());
    }
}
