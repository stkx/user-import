<?php
declare(strict_types=1);

namespace App\Common\DB;

interface ConnectionInterface
{
    public function select(string $table, array $columns): array;

    public function upsert(string $string, string $id, array $columns): void;

    public function insertBatch(string $table, array $columns): void;
}
