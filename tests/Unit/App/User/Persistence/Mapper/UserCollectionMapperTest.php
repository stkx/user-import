<?php

use App\User\Domain\Core\User;
use App\User\Persistence\Mapper\UserCollectionMapper;
use App\User\Persistence\Mapper\UserMapper;
use PHPUnit\Framework\TestCase;

class UserCollectionMapperTest extends TestCase
{
    private UserCollectionMapper $mapper;
    /**
     * @var User|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $user;
    /**
     * @var UserMapper|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $userMapper;

    protected function setUp()
    {
        $this->userMapper = Mockery::mock(UserMapper::class);

        $this->mapper = new UserCollectionMapper(
            $this->userMapper
        );

        $this->user = Mockery::mock(User::class);
    }

    public function testMapFromArray()
    {
        $mock = $this->user;

        $result = $this->mapper->mapFromArray([
            $mock,
        ]);

        $this->assertContains($this->user, $result->getValues());
        $this->assertCount(1, $result->getValues());
    }

    public function testMapFromRows()
    {
        $this->userMapper->allows(['map' => $this->user]);

        $result = $this->mapper->mapFromRows([['blah']]);

        $this->assertContains($this->user, $result->getValues());
        $this->assertCount(1, $result->getValues());
    }
}
