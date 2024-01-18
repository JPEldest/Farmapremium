<?php

namespace Module\User\Domain\Read;

use App\Module\User\Domain\Exceptions\UserNotFoundException;
use App\Module\User\Domain\Read\UserFinder;
use App\Module\User\Domain\ValueObject\UserId;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Module\User\Domain\Read\InMemoryUserReadRepository;
use Tests\Unit\Module\User\Domain\Read\StubUserBuilder;
use Tests\Unit\Module\User\Domain\ValueObject\StubUserId;

class UserFinderTest extends TestCase
{
    private UserFinder $userFinder;

    private InMemoryUserReadRepository $userReadRepository;

    protected function setUp(): void
    {
        $this->userReadRepository = new InMemoryUserReadRepository();
        $this->userFinder = new UserFinder($this->userReadRepository);

        parent::setUp();
    }

    /**
     * @test
     */
    public function should_not_get_a_user(): void
    {
        $this->expectException(UserNotFoundException::class);

        $this->userFinder->__invoke(StubUserId::random());
    }

    /**
     * @test
     */
    public function should_get_a_user(): void
    {
        $user = StubUserBuilder::create()->build();
        $this->userReadRepository->save($user);

        $userFound = $this->userFinder->__invoke(UserId::fromString($user->id()));

        $this->assertEquals($userFound, $user);
    }
}
