<?php
declare(strict_types=1);

namespace App\User\Persistence\Event;

use App\Common\Event\EventInterface;
use App\User\Domain\Core\User;

class UserSaved implements EventInterface
{
    private User $user;

    /**
     * UserSaved constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getAlias(): string
    {
        return 'event.user_saved';
    }
}
