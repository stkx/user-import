<?php

use App\User\Domain\Core\Email;
use App\User\Domain\Core\IdGeneratorInterface;
use App\User\Domain\Core\Name;
use App\User\Domain\Core\Status\AbstractStatus;
use App\User\Domain\Core\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public $defaultStatus;
    public $generator;
    public $nameObject;
    public $emailObject;

    protected function setUp()
    {
        $this->defaultStatus = Mockery::mock(AbstractStatus::class);
        $this->generator = Mockery::spy(IdGeneratorInterface::class);
        $this->nameObject = Mockery::spy(Name::class);
        $this->emailObject = Mockery::spy(Email::class);
    }

    private function makeUser(AbstractStatus $status)
    {
        return new User(
            $this->generator,
            $this->nameObject,
            $this->emailObject,
            $status
        );
    }

    public function testActivate()
    {
        $user = $this->makeUser($this->defaultStatus);

        $this->defaultStatus->shouldReceive('ensureTransitionIsPossible');

        $user->activate();

        $this->assertTrue($user->isActive());
    }

    public function testBan()
    {
        $user = $this->makeUser($this->defaultStatus);

        $this->defaultStatus->shouldReceive('ensureTransitionIsPossible');

        $user->ban();

        $this->assertTrue($user->isBanned());
    }

    public function testDeactivate()
    {
        $user = $this->makeUser($this->defaultStatus);

        $this->defaultStatus->shouldReceive('ensureTransitionIsPossible');

        $user->deactivate();

        $this->assertTrue($user->isInactive());
    }

    public function testGetId()
    {
        $user = $this->makeUser($this->defaultStatus);

        $this->assertNotEmpty($user->getId());
    }

    public function testGetName()
    {
        $user = $this->makeUser($this->defaultStatus);

        $this->assertNotEmpty($user->getName());
    }

    public function testGetEmail()
    {
        $user = $this->makeUser($this->defaultStatus);

        $this->assertNotEmpty($user->getEmail());
    }
}
