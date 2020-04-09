<?php
declare(strict_types=1);

namespace App\User\Persistence\DTO;

class SearchCriteria
{
    private string $email;

    private string $name;

    /**
     * SearchCriteria constructor.
     */
    public function __construct(string $email, string $name)
    {
        $this->email = $email;
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
