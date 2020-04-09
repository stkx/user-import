<?php

use App\User\Domain\Core\Status\Active;
use App\User\Domain\Core\Status\Banned;
use PHPUnit\Framework\TestCase;

class BannedTest extends TestCase
{
    private Banned $statusObject;

    protected function setUp()
    {
        $this->statusObject = new Banned();
    }

    public function availableTransitions()
    {
        return [
            [Active::class],
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
        $this->assertEquals('banned', $this->statusObject->getAlias());
    }
}
