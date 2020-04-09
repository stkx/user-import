<?php

use App\User\Domain\Core\Email;
use App\User\Domain\Core\Exception\InvalidPropertyValue;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function validEmails()
    {
        return [
            ['example@test.com'],
        ];
    }

    /**
     * @dataProvider validEmails
     */
    public function testValidationIsPassedOnEmail($email)
    {
        new Email($email);
        $this->assertTrue(true);
    }

    public function invalidEmails()
    {
        return [
            ['example@test'],
            ['string'],
            [''],
            [0],
        ];
    }

    /**
     * @dataProvider invalidEmails
     */
    public function testExceptionThrownOnInvalidEmails($email)
    {
        $this->expectException(InvalidPropertyValue::class);

        new Email($email);
    }

    public function testValueIsRetrievable()
    {
        $email = new Email('example@test.com');

        $this->assertEquals('example@test.com', $email->getValue());
    }
}
