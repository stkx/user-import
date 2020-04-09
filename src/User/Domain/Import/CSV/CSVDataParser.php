<?php
declare(strict_types=1);

namespace App\User\Domain\Import\CSV;

use App\User\Domain\Import\Core\ImportedUser;
use App\User\Domain\Import\CSV\Exception\InvalidCSVString;

class CSVDataParser
{
    public function parse(array $data): ImportedUser
    {
        if (!isset($data[0], $data[1])) {
            throw new InvalidCSVString();
        }

        $dto = new ImportedUser();
        $dto->email = $data[0];
        $dto->name = $data[1];

        return $dto;
    }
}
