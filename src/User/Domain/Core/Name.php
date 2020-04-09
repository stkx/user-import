<?php
declare(strict_types=1);

namespace App\User\Domain\Core;

use App\User\Domain\Core\Exception\InvalidPropertyValue;

class Name
{
    private string $value;

    /**
     * Name constructor.
     *
     * @throws InvalidPropertyValue
     */
    public function __construct(string $value)
    {
        if (mb_strlen($value) > 255) {
            throw new InvalidPropertyValue('Name should be shorter than 255 symbols');
        }

        if ('' === $value) {
            throw new InvalidPropertyValue('Name should not be empty');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
