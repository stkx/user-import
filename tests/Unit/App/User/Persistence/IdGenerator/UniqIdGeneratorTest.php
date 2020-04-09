<?php

use App\User\Persistence\IdGenerator\UniqIdGenerator;
use PHPUnit\Framework\TestCase;

class UniqIdGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $generator = new UniqIdGenerator();

        $this->assertNotEmpty($generator->generate());
    }
}
