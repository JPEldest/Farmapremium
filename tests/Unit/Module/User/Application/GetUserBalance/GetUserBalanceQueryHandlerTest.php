<?php

namespace Tests\Unit\Module\User\Application\GetUserBalance;

use App\Module\User\Application\GetUserBalance\GetUserBalanceQuery;
use App\Module\User\Application\GetUserBalance\GetUserBalanceQueryHandler;
use App\Module\User\Domain\Exceptions\UserNotFoundException;
use App\Module\User\Domain\Read\User;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Module\User\Domain\Read\InMemoryUserReadRepository;
use Tests\Unit\Module\User\Domain\Read\StubUserBuilder;
use Tests\Unit\Module\User\Domain\ValueObject\StubBalance;

class GetUserBalanceQueryHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        $this->repository = new InMemoryUserReadRepository();
        $this->getUserBalanceQueryHandler = new GetUserBalanceQueryHandler($this->repository);
        parent::setUp();
    }

    /**
     * @test
     */
    public function should_return_user_balance()
    {
        $balance = StubBalance::random()->asInt();
        $user = StubUserBuilder::create()->withBalance($balance)->build();

        $this->repository->save($user);
        $query = GetUserBalanceQuery::create($user->id());

        $user = $this->getUserBalanceQueryHandler->handle($query);

        self::assertInstanceOf(User::class, $user);
        self::assertEquals($user->balance(), $balance);
    }

    /**
     * @test
     */
    public function should_not_find_user()
    {
        $this->expectException(UserNotFoundException::class);

        $balance = StubBalance::random()->asInt();
        $user = StubUserBuilder::create()->withBalance($balance)->build();

        $query = GetUserBalanceQuery::create($user->id());

        $this->getUserBalanceQueryHandler->handle($query);
    }
}
