<?php
declare(strict_types=1);

namespace App\User\Command;

use App\User\Persistence\DTO\SearchCriteria;
use App\User\Persistence\UserRepositoryInterface;

class DoSearchAction
{
    private UserRepositoryInterface $repository;

    /**
     * DoSearchAction constructor.
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * DoSearchAction constructor.
     */
    public function run(string $email, string $name): array
    {
        $criteria = new SearchCriteria($email, $name);

        $users = $this->repository->find($criteria);

        return $users->getValues();
    }
}
