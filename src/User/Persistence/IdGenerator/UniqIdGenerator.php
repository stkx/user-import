<?php
declare(strict_types=1);

namespace App\User\Persistence\IdGenerator;

use App\User\Domain\Core\IdGeneratorInterface;
use App\User\Domain\Core\UserId;

class UniqIdGenerator implements IdGeneratorInterface
{
    public function generate(): UserId
    {
        return new UserId(uniqid());
    }
}
