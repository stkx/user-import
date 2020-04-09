<?php
declare(strict_types=1);

namespace App\User\Persistence;

use App\User\Domain\Core\User;
use App\User\Persistence\DTO\SearchCriteria;
use App\User\Persistence\DTO\UserCollection;

interface UserRepositoryInterface
{
    public function find(SearchCriteria $criteria): UserCollection;

    public function save(User $user): void;

    public function saveAll(UserCollection $userCollection): void;
}
