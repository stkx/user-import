<?php

use App\User\Domain\Core\Status\Active;
use App\User\Domain\Core\Status\Banned;
use App\User\Domain\Core\Status\Inactive;
use PHPUnit\Framework\TestCase;

class InactiveTest extends TestCase
{
    private Inactive $statusObject;

    protected function setUp()
    {
        $this->statusObject = new Inactive();
    }

    public function transitionList()
    {
        return [
            [Active::class],
            [Banned::class],
            [Inactive::class],
        ];
    }

    /**
     * @dataProvider transitionList
     */
    public function testTransitionIsPossible($transitionClass)
    {
        $newStatus = \Mockery::spy($transitionClass)->makePartial();

        $result = $this->statusObject->transitionIsPossible($newStatus);

        $this->assertFalse($result);
    }

    public function testAliasIsOk()
    {
        $this->assertEquals('inactive', $this->statusObject->getAlias());
    }
}
