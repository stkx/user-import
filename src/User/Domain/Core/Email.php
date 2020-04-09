<?php
declare(strict_types=1);

namespace App\User\Domain\Core;

use App\User\Domain\Core\Exception\InvalidPropertyValue;

class Email
{
    private string $value;

    /**
     * Email constructor.
     *
     * @throws InvalidPropertyValue
     */
    public function __construct(string $value)
    {
        if (!preg_match('/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/', $value)) {
            throw new InvalidPropertyValue('Email is invalid');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
