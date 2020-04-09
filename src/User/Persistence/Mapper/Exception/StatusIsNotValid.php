<?php
declare(strict_types=1);

namespace App\User\Persistence\Mapper\Exception;

class StatusIsNotValid extends \RuntimeException
{
    private string $statusString;

    public function __construct(string $statusString, $message = '')
    {
        parent::__construct($message);
        $this->statusString = $statusString;
    }

    public function getStatusString(): string
    {
        return $this->statusString;
    }
}
