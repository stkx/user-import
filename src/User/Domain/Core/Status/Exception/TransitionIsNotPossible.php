<?php
declare(strict_types=1);

namespace App\User\Domain\Core\Status\Exception;

use App\User\Domain\Core\Status\AbstractStatus;

class TransitionIsNotPossible extends \Exception
{
    private AbstractStatus $to;

    /**
     * TransitionIsNotPossible constructor.
     */
    public function __construct(AbstractStatus $to)
    {
        $this->to = $to;
        parent::__construct();
    }

    public function getTo(): AbstractStatus
    {
        return $this->to;
    }
}
