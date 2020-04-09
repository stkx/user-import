<?php
declare(strict_types=1);

namespace App\User\Persistence\Mapper;

use App\User\Persistence\DTO\UserCollection;
use App\User\Persistence\Mapper;

class UserCollectionMapper
{
    /**
     * @var UserMapper
     */
    private Mapper\UserMapper $mapper;

    /**
     * UserCollectionMapper constructor.
     */
    public function __construct(UserMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function mapFromRows(array $rows): UserCollection
    {
        $users = [];
        foreach ($rows as $row) {
            $users[] = $this->mapper->map($row);
        }

        return new UserCollection($users);
    }

    public function mapFromArray(array $users): UserCollection
    {
        return new UserCollection($users);
    }
}
