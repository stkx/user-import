<?php

use App\User\Domain\Core\Exception\InvalidPropertyValue;
use App\User\Domain\Import\Core\Exception\ImportedValueIsNotValid;
use App\User\Domain\Import\Core\ImportedUser;

class ImportedUserMapperTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \App\User\Common\UserFactory|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = Mockery::spy(\App\User\Common\UserFactory::class);
    }

    public function testMapUserFromDTO()
    {
        $class = new \App\User\Domain\Import\Core\ImportedUserMapper($this->factory);

        $dto = new ImportedUser();
        $dto->name = 'name';
        $dto->email = 'email';

        $this
            ->factory
            ->shouldReceive('create')
            ->andThrow(new InvalidPropertyValue());

        $this->expectException(ImportedValueIsNotValid::class);

        $class->mapUserFromDTO($dto);
    }
}
