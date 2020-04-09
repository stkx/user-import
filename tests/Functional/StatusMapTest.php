<?php

use App\User\Common\StatusMap;
use App\User\Domain\Core\Status\AbstractStatus;
use PHPUnit\Framework\TestCase;

/**
 * @codeCoverageIgnore
 */
class StatusMapTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    private StatusMap $statusMap;
    /**
     * @var AbstractStatus|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $statusObject;

    protected function setUp()
    {
        $status = Mockery::mock(AbstractStatus::class);
        $status->shouldReceive('getAlias')->andReturn('someTestAlias');

        $this->statusObject = $status;

        $this->statusMap = new StatusMap();
    }

    public function testRegisteredStatusCanBeFound()
    {
        $this->statusMap->registerStatus($this->statusObject);

        $result = $this->statusMap->findStatus('someTestAlias');

        $this->assertEquals($this->statusObject, $result);
    }

    public function testExceptionIsThrownWhenNoStatus()
    {
        $this->statusMap->registerStatus($this->statusObject);

        $this->expectException(InvalidArgumentException::class);

        $this->statusMap->findStatus('someUnexistingAlias');
    }
}
