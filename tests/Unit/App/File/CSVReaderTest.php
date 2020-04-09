<?php

use App\Common\File\CSVReader;
use PHPUnit\Framework\TestCase;

class CSVReaderTest extends TestCase
{
    public function testReadFileExceptionThrown()
    {
        $object = new CSVReader();

        $this->expectException(InvalidArgumentException::class);

        $object->readFile('not-a-resource');
    }
}
