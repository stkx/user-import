<?php
declare(strict_types=1);

namespace App\User\Common;

use App\User\Domain\Core\Email;
use App\User\Domain\Core\Exception\InvalidPropertyValue;
use App\User\Domain\Core\IdGeneratorInterface;
use App\User\Domain\Core\Name;
use App\User\Domain\Core\Status\AbstractStatus;
use App\User\Domain\Core\User;

class UserFactory
{
    private IdGeneratorInterface $generator;

    /**
     * UserFactory constructor.
     */
    public function __construct(IdGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @throws InvalidPropertyValue
     */
    public function create(string $name, string $email, AbstractStatus $status): User
    {
        return new User(
            $this->generator,
            new Name($name),
            new Email($email),
            $status
        );
    }
}
