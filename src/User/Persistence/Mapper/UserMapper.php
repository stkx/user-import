<?php
declare(strict_types=1);

namespace App\User\Persistence\Mapper;

use App\User\Common\UserFactory;
use App\User\Domain\Core\Exception\InvalidPropertyValue;
use App\User\Domain\Core\User;
use App\User\Persistence\Mapper\Exception\InvalidRowData;

class UserMapper
{
    private UserFactory $factory;

    private StatusValueMapper $statusValueMapper;

    /**
     * UserMapper constructor.
     */
    public function __construct(UserFactory $factory, StatusValueMapper $statusValueMapper)
    {
        $this->factory = $factory;
        $this->statusValueMapper = $statusValueMapper;
    }

    /**
     * @throws InvalidRowData
     */
    public function map(array $row): User
    {
        foreach (['name', 'email', 'status'] as $prop) {
            if (!isset($row[$prop])) {
                throw new InvalidRowData(sprintf('Missing field %s', $prop));
            }
        }

        try {
            return $this->factory->create(
                $row['name'],
                $row['email'],
                $this->statusValueMapper->convertStringToStatus($row['status'])
            );
        } catch (InvalidPropertyValue $e) {
            throw new InvalidRowData(sprintf('Mapping is failed: %s', $e->getMessage()));
        }
    }
}
