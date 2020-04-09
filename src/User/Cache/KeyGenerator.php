<?php
declare(strict_types=1);

namespace App\User\Cache;

use App\User\Persistence\DTO\SearchCriteria;

class KeyGenerator
{
    public function generateKey(SearchCriteria $criteria): string
    {
        return sprintf('search::%s%s', $criteria->getName(), $criteria->getEmail());
    }
}
