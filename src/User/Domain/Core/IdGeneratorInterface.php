<?php
declare(strict_types=1);

namespace App\User\Domain\Core;

interface IdGeneratorInterface
{
    public function generate(): UserId;
}
