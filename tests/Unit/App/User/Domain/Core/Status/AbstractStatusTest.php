<?php

use App\User\Domain\Core\Status\AbstractStatus;
use App\User\Domain\Core\Status\Exception\TransitionIsNotPossible;
use PHPUnit\Framework\TestCase;

class AbstractStatusTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testExceptionIsThrownWhenNoTransitionAvailable()
    {
        $status = Mockery::spy(AbstractStatus::class)->makePartial();

        $status
            ->shouldReceive('transitionIsPossible')
            ->andReturn(false);

        $this->expectException(TransitionIsNotPossible::class);

        $status->ensureTransitionIsPossible(
            Mockery::spy(AbstractStatus::class)
        );
    }

    public function testExceptionIsNotThrownWhenTransitionAvailable()
    {
        $status = Mockery::spy(AbstractStatus::class)->makePartial();

        $status
            ->shouldReceive('transitionIsPossible')
            ->andReturn(true);

        $status->ensureTransitionIsPossible(
            Mockery::spy(AbstractStatus::class)
        );
    }
}
