<?php
declare(strict_types=1);

namespace App\User\Common;

use App\User\Domain\Core\Status\AbstractStatus;

class StatusMap
{
    /**
     * @var AbstractStatus[]
     */
    private array $statuses = [];

    public function registerStatus(AbstractStatus $status)
    {
        $this->statuses[] = $status;
    }

    public function findStatus(string $alias): AbstractStatus
    {
        foreach ($this->statuses as $status) {
            if ($status->getAlias() === $alias) {
                return $status;
            }
        }

        throw new \InvalidArgumentException(sprintf('No status matching to alias `%s` found', $alias));
    }
}
