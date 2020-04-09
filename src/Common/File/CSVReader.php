<?php
declare(strict_types=1);

namespace App\Common\File;

use InvalidArgumentException;

class CSVReader
{
    public function readFile($resource)
    {
        if (false === is_resource($resource)) {
            throw new InvalidArgumentException(sprintf('Argument must be a valid resource type. %s given.', gettype($resource)));
        }

        return fgetcsv($resource);
    }
}
