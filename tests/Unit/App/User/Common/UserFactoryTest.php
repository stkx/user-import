<?php

use App\User\Common\UserFactory;
use App\User\Domain\Core\IdGeneratorInterface;
use App\User\Domain\Core\Status\Active;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    /**
     * @var IdGeneratorInterface|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $generator;

    private UserFactory $userFactory;

    protected function setUp()
    {
        $this->generator = Mockery::spy(IdGeneratorInterface::class);

        $this->userFactory = new UserFactory($this->generator);

        parent::setUp();
    }

    public function testCreate()
    {
        $user = $this->userFactory->create('name', 'v@example.com', new Active());

        $this->assertEquals('name', $user->getName()->getValue());
        $this->assertEquals('v@example.com', $user->getEmail()->getValue());
    }
}
