<?php
declare(strict_types=1);

namespace App\User\Persistence\DTO;

use App\User\Domain\Core\User;

class UserCollection
{
    private array $users;

    /**
     * UserCollection constructor.
     *
     * @param User[] $users
     */
    public function __construct(array $users)
    {
        foreach ($users as $user) {
            if (!$user instanceof User) {
                throw new \InvalidArgumentException(sprintf('Only instances of %s is available', User::class));
            }
            $this->users[] = $user;
        }
    }

    public function getValues(): array
    {
        return $this->users;
    }
}
