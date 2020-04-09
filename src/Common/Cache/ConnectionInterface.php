<?php
declare(strict_types=1);

namespace App\Common\Cache;

interface ConnectionInterface
{
    public function read(string $cacheKey);

    public function write(string $cacheKey, $value, $group = 'default'): void;

    public function resetGroup($group = 'default'): void;
}
