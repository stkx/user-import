<?php

use App\User\Cache\GroupTagGenerator;
use PHPUnit\Framework\TestCase;

class GroupTagGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $object = new GroupTagGenerator();

        $tag = $object->generate();

        $this->assertEquals('815258723e86c4a04ccf826444612d04', $tag);
    }
}
