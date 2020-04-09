<?php

use App\User\Common\UserFactory;
use App\User\Domain\Core\Exception\InvalidPropertyValue;
use App\User\Persistence\Mapper\Exception\InvalidRowData;
use App\User\Persistence\Mapper\StatusValueMapper;
use App\User\Persistence\Mapper\UserMapper;
use PHPUnit\Framework\TestCase;

class UserMapperTest extends TestCase
{
    private UserMapper $userMapper;
    /**
     * @var StatusValueMapper|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $statusValueMapper;
    /**
     * @var UserFactory|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = Mockery::spy(UserFactory::class);
        $this->statusValueMapper = Mockery::spy(StatusValueMapper::class);

        $this->userMapper = new UserMapper(
            $this->factory,
            $this->statusValueMapper
        );
    }

    public function dataSets()
    {
        return [
            ['name'],
            ['email'],
            ['status'],
        ];
    }

    /**
     * @dataProvider dataSets
     */
    public function testExceptionIsThrownOnMissingData($fieldToRemove)
    {
        $data = ['name' => 'name', 'email' => 'email', 'status' => 'status'];

        unset($data[$fieldToRemove]);

        $this->expectException(InvalidRowData::class);

        $this->userMapper->map($data);
    }

    /**
     * @dataProvider dataSets
     */
    public function testExceptionIsReplacedOnMissingData($fieldToRemove)
    {
        $data = ['name' => 'name', 'email' => 'email', 'status' => 'status'];

        $this->expectException(InvalidRowData::class);

        $this->factory
            ->shouldReceive('create')
            ->andThrow(new InvalidPropertyValue());

        $this->userMapper->map($data);
    }

    public function testUserIsReturned()
    {
        $data = ['name' => 'name', 'email' => 'email', 'status' => 'status'];

        $result = $this->userMapper->map($data);

        $this->assertNotEmpty($result);
    }
}
