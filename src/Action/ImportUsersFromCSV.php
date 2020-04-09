<?php
declare(strict_types=1);

namespace App\Action;

use App\User\Command\PerformUserImportFromCSV;

class ImportUsersFromCSV
{
    private PerformUserImportFromCSV $userImportFromCSV;

    /**
     * ImportUsersFromCSV constructor.
     */
    public function __construct(PerformUserImportFromCSV $userImportFromCSV)
    {
        $this->userImportFromCSV = $userImportFromCSV;
    }

    public function run($resource): void
    {
        $this->userImportFromCSV->run($resource);
    }
}
