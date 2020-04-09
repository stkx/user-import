<?php
declare(strict_types=1);

namespace App\User\Domain\Core;

use App\User\Domain\Core\Status\AbstractStatus;
use App\User\Domain\Core\Status\Active;
use App\User\Domain\Core\Status\Banned;
use App\User\Domain\Core\Status\Inactive;

class User
{
    private Name $name;

    private Email $email;

    private UserId $id;

    private AbstractStatus $status;

    /**
     * User constructor.
     */
    public function __construct(
        IdGeneratorInterface $idGenerator,
        Name $name,
        Email $email,
        AbstractStatus $status
    ) {
        $this->id = $idGenerator->generate();
        $this->name = $name;
        $this->email = $email;
        $this->status = $status;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function activate(): void
    {
        $newStatus = new Active();

        $this->status->ensureTransitionIsPossible($newStatus);

        $this->status = $newStatus;
    }

    public function ban(): void
    {
        $newStatus = new Banned();

        $this->status->ensureTransitionIsPossible($newStatus);

        $this->status = $newStatus;
    }

    public function deactivate(): void
    {
        $newStatus = new Inactive();

        $this->status->ensureTransitionIsPossible($newStatus);

        $this->status = $newStatus;
    }

    public function isActive(): bool
    {
        return $this->status instanceof Active;
    }

    public function isBanned(): bool
    {
        return $this->status instanceof Banned;
    }

    public function isInactive(): bool
    {
        return $this->status instanceof Inactive;
    }
}
