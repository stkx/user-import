<?php
declare(strict_types=1);

namespace App\User\Domain\Core\Status;

class Active extends AbstractStatus
{
    public function transitionIsPossible(AbstractStatus $newStatus): bool
    {
        return
            $newStatus instanceof Inactive ||
            $newStatus instanceof Banned;
    }

    public function getAlias(): string
    {
        return 'active';
    }
}
