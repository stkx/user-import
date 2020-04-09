<?php

use App\User\Domain\Core\Exception\InvalidPropertyValue;
use App\User\Domain\Core\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function validNames()
    {
        return [
            ['0'],
            ['null'],
            ['Some name'],
            [str_pad('1', 255)],
        ];
    }

    /**
     * @dataProvider validNames
     */
    public function testValidationIsPassedOnName($name)
    {
        new Name($name);
        $this->assertTrue(true);
    }

    public function invalidNames()
    {
        return [
            [str_pad('1', 256)],
            [''],
        ];
    }

    /**
     * @dataProvider invalidNames
     */
    public function testExceptionThrownOnInvalidNames($name)
    {
        $this->expectException(InvalidPropertyValue::class);

        new Name($name);
    }

    public function testValueIsRetrievable()
    {
        $name = new Name('123');

        $this->assertEquals('123', $name->getValue());
    }
}
