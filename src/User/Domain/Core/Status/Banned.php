<?php
declare(strict_types=1);

namespace App\User\Domain\Core\Status;

class Banned extends AbstractStatus
{
    public function transitionIsPossible(AbstractStatus $newStatus): bool
    {
        return $newStatus instanceof Active;
    }

    public function getAlias(): string
    {
        return 'banned';
    }
}
