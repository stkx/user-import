<?php

use App\User\Domain\Core\Status\Active;
use App\User\Domain\Core\Status\Banned;
use App\User\Domain\Core\Status\Inactive;
use PHPUnit\Framework\TestCase;

class ActiveTest extends TestCase
{
    private Active $statusObject;

    protected function setUp()
    {
        $this->statusObject = new Active();
    }

    public function availableTransitions()
    {
        return [
            [Banned::class],
            [Inactive::class],
        ];
    }

    /**
     * @dataProvider availableTransitions
     */
    public function testTransitionIsPossible($transitionClass)
    {
        $newStatus = \Mockery::spy($transitionClass)->makePartial();

        $result = $this->statusObject->transitionIsPossible($newStatus);

        $this->assertTrue($result);
    }

    public function testAliasIsOk()
    {
        $this->assertEquals('active', $this->statusObject->getAlias());
    }
}
