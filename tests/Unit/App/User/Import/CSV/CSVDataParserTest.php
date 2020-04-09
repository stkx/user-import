<?php

use App\User\Domain\Import\CSV\CSVDataParser;
use App\User\Domain\Import\CSV\Exception\InvalidCSVString;
use PHPUnit\Framework\TestCase;

class CSVDataParserTest extends TestCase
{
    /**
     * @var CSVDataParser
     */
    private $parser;

    protected function setUp()
    {
        $this->parser = new CSVDataParser();

        parent::setUp();
    }

    public function testExceptionThrownOnEmptyValues()
    {
        $this->expectException(InvalidCSVString::class);

        $this->parser->parse([]);
    }

    public function testParseCSVArray()
    {
        $result = $this->parser->parse(['email', 'name']);

        $this->assertEquals('email', $result->email);
        $this->assertEquals('name', $result->name);
    }
}
