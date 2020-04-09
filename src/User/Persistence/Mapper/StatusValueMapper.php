<?php
declare(strict_types=1);

namespace App\User\Persistence\Mapper;

use App\User\Common\StatusMap;
use App\User\Domain\Core\Status\AbstractStatus;
use App\User\Persistence\Mapper\Exception\StatusIsNotValid;

class StatusValueMapper
{
    private StatusMap $map;

    /**
     * StatusValueMapper constructor.
     */
    public function __construct(StatusMap $map)
    {
        $this->map = $map;
    }

    public function convertStatusToString(AbstractStatus $status): string
    {
        return $status->getAlias();
    }

    public function convertStringToStatus(string $string): AbstractStatus
    {
        try {
            return $this->map->findStatus($string);
        } catch (\InvalidArgumentException $exception) {
            throw new StatusIsNotValid(sprintf('Status `%s` is not supported', $string));
        }
    }
}
