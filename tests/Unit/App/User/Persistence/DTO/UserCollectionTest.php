<?php

use App\User\Domain\Core\User;
use App\User\Persistence\DTO\UserCollection;
use PHPUnit\Framework\TestCase;

class UserCollectionTest extends TestCase
{
    /**
     * @var User|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $user;

    protected function setUp()
    {
        $this->user = \Mockery::spy(User::class);
    }

    public function testExceptionIsThrownWhenNotAUserPassed()
    {
        $this->expectException(\InvalidArgumentException::class);

        $collection = new UserCollection([
            $this->user,
            null,
        ]);
    }

    public function testValuesAreProperlySet()
    {
        $collection = new UserCollection([
            $this->user,
        ]);

        $values = $collection->getValues();

        $this->assertCount(1, $values);
        $this->assertContains($this->user, $values);
    }
}
