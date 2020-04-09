<?php
declare(strict_types=1);

namespace App\User\Domain\Core\Status;

class Inactive extends AbstractStatus
{
    public function transitionIsPossible(AbstractStatus $newStatus): bool
    {
        return false;
    }

    public function getAlias(): string
    {
        return 'inactive';
    }
}
