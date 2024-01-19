<?php

namespace Tests\Unit\Module\Transaction\Domain;

use App\Module\Pharmacy\Domain\ValueObject\PharmacyId;
use App\Module\Transaction\Domain\Transaction;
use App\Module\Transaction\Domain\ValueObject\TransactionType;
use App\Module\User\Domain\Exceptions\NotEnoughBalanceException;
use App\Module\User\Domain\ValueObject\UserId;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Module\Pharmacy\Domain\ValueObject\StubPharmacyId;
use Tests\Unit\Module\Transaction\Domain\ValueObject\StubPoints;
use Tests\Unit\Module\Transaction\Domain\ValueObject\StubTransactionType;
use Tests\Unit\Module\User\Domain\ValueObject\StubUserId;

class TransactionTest extends TestCase
{
    /**
     * @test
     */
    public function should_create_transaction():void
    {
        $transaction = StubTransactionBuilder::create()->build();

        $this->assertInstanceOf(Transaction::class, $transaction);
    }

    /**
     * @test
     * @dataProvider pharmacyAndUserDataProvider
     */
    public function should_be_able_to_create_transaction_of_different_users_pharmacy_and_type(UserId $userId, PharmacyId $pharmacyId, TransactionType $transactionType):void
    {
        $transaction = StubTransactionBuilder::create()
            ->withUserId($userId)
            ->withPharmacyId($pharmacyId)
            ->withTransactionType($transactionType)
            ->build();

        $this->assertInstanceOf(Transaction::class, $transaction);
    }

    public static function pharmacyAndUserDataProvider():array
    {
        return [
            ["Give points to User" => StubUserId::random(), StubPharmacyId::random(), StubTransactionType::give()],
            ["Redeem points from User" => StubUserId::random(), StubPharmacyId::random(), StubTransactionType::redeem()]
        ];
    }

    /**
     * @test
     */
    public function should_redeem_points()
    {
        $startingPoints = StubPoints::withPoints(50);
        $transaction = StubTransactionBuilder::create()->withPoints($startingPoints)->build();
        $pointsToRedeem = StubPoints::withPoints(30);
        $transaction->redeemPoints($pointsToRedeem);

        $difference = $startingPoints->asInt() - $pointsToRedeem->asInt();

        self::assertEquals($transaction->pointsLeft()->asInt(), $difference);
    }

    /**
     * @test
     */
    public function should_redeem_points_to_zero()
    {
        $startingPoints = StubPoints::withPoints(50);
        $transaction = StubTransactionBuilder::create()->withPoints($startingPoints)->build();
        $pointsToRedeem = $startingPoints;
        $transaction->redeemPoints($pointsToRedeem);

        self::assertEquals(0, $transaction->pointsLeft()->asInt());
    }

    /**
     * @test
     */
    public function should_not_redeem_points()
    {
        self::expectException(NotEnoughBalanceException::class);
        $startingPoints = StubPoints::withPoints(30);
        $transaction = StubTransactionBuilder::create()->withPoints($startingPoints)->build();
        $pointsToRedeem = StubPoints::withPoints(50);
        $transaction->redeemPoints($pointsToRedeem);
    }
}
