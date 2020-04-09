<?php

use App\User\Cache\KeyGenerator;
use App\User\Persistence\DTO\SearchCriteria;
use PHPUnit\Framework\TestCase;

class KeyGeneratorTest extends TestCase
{
    public function testGenerateKey()
    {
        $object = new KeyGenerator();

        $key = $object->generateKey(new SearchCriteria('email', 'name'));

        $this->assertEquals('search::nameemail', $key);
    }
}
