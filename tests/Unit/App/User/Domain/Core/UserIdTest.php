<?php

use App\User\Domain\Core\Exception\InvalidPropertyValue;
use App\User\Domain\Core\UserId;
use PHPUnit\Framework\TestCase;

class UserIdTest extends TestCase
{
    public function validUserIds()
    {
        return [
            ['0'],
            ['null'],
            ['Some userId'],
            [str_pad('1', 255)],
        ];
    }

    /**
     * @dataProvider validUserIds
     */
    public function testValidationIsPassedOnUserId($userId)
    {
        new UserId($userId);
        $this->assertTrue(true);
    }

    public function invalidUserIds()
    {
        return [
            [str_pad('1', 256)],
            [''],
        ];
    }

    /**
     * @dataProvider invalidUserIds
     */
    public function testExceptionThrownOnInvalidUserIds($userId)
    {
        $this->expectException(InvalidPropertyValue::class);

        new UserId($userId);
    }

    public function testValueIsRetrievable()
    {
        $userId = new UserId('123');

        $this->assertEquals('123', $userId->getValue());
    }
}
