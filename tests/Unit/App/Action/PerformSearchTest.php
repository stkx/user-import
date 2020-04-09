<?php

use App\Action\Search;
use App\User\Command\DoSearchAction;
use PHPUnit\Framework\TestCase;

class PerformSearchTest extends TestCase
{
    /**
     * @var Search
     */
    private $object;
    /**
     * @var DoSearchAction|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $doSearchAction;

    protected function setUp()
    {
        $this->doSearchAction = Mockery::spy(DoSearchAction::class);

        $this->object = new Search($this->doSearchAction);

        parent::setUp();
    }

    public function testRun()
    {
        $result = $this->object->run('test@email.com', 'example');

        $this->assertJson($result);
    }
}
