<?php

namespace Tests\Unit\Module\User\Domain;

use App\Module\User\Domain\Exceptions\NotEnoughBalanceException;
use App\Module\User\Domain\User;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Module\User\Domain\ValueObject\StubBalance;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function should_create_model_user(): void
    {
        $user = StubUserBuilder::create()->build();

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function should_be_able_to_add_points(): void
    {
        $startingBalance = StubBalance::random();
        $user = StubUserBuilder::create()->withBalance($startingBalance)->build();
        $user->gatherPoints(StubBalance::random());

        self::assertTrue($user->balance()->isBiggerThan($startingBalance));
    }

    /**
     * @test
     */
    public function should_be_able_to_redeem_points(): void
    {
        $startingBalance = StubBalance::ofBalance(50);
        $pointsToRedeem = StubBalance::ofBalance(5);
        $user = StubUserBuilder::create()->withBalance($startingBalance)->build();
        $user->redeemPoints($pointsToRedeem);

        self::assertTrue($startingBalance->isBiggerThan($user->balance()));
    }

    /**
     * @test
     */
    public function should_not_redeem_points_if_balance_is_not_enough(): void
    {
        $this->expectException(NotEnoughBalanceException::class);

        $user = StubUserBuilder::create()
            ->withBalance(StubBalance::ofBalance(15))
            ->build();

        $user->redeemPoints(StubBalance::ofBalance(20));
    }
}
