<?php
declare(strict_types=1);

namespace App\User\Domain\Core\Status;

use App\User\Domain\Core\Status\Exception\TransitionIsNotPossible;

abstract class AbstractStatus
{
    abstract public function transitionIsPossible(AbstractStatus $newStatus): bool;

    abstract public function getAlias(): string;

    /**
     * @throws TransitionIsNotPossible
     */
    public function ensureTransitionIsPossible(AbstractStatus $newStatus): void
    {
        if (!$this->transitionIsPossible($newStatus)) {
            throw new TransitionIsNotPossible($newStatus);
        }
    }
}
