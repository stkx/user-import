<?php
declare(strict_types=1);

namespace App\User\Cache;

use App\User\Domain\Core\User;

class GroupTagGenerator
{
    public function generate(): string
    {
        return md5(User::class);
    }
}
