<?php
declare(strict_types=1);

namespace App\User\Persistence;

use App\Common\DB\ConnectionInterface;
use App\Common\Event\Dispatcher;
use App\User\Domain\Core\User;
use App\User\Persistence\DTO\SearchCriteria;
use App\User\Persistence\DTO\UserCollection;
use App\User\Persistence\Event\UserSaved;
use App\User\Persistence\Mapper\UserCollectionMapper;

class UserRepository implements UserRepositoryInterface
{
    private ConnectionInterface $dbConnection;
    private Mapper\UserCollectionMapper $collectionMapper;
    private Dispatcher $dispatcher;

    /**
     * UserRepository constructor.
     */
    public function __construct(
        ConnectionInterface $dbConnection,
        UserCollectionMapper $collectionMapper,
        Dispatcher $dispatcher
    ) {
        $this->dbConnection = $dbConnection;
        $this->collectionMapper = $collectionMapper;
        $this->dispatcher = $dispatcher;
    }

    public function find(SearchCriteria $criteria): UserCollection
    {
        $rows = $this->dbConnection->select('user', [
            'email' => $criteria->getEmail(),
            'name' => $criteria->getName(),
        ]);

        return $this->collectionMapper->mapFromRows($rows);
    }

    public function save(User $user): void
    {
        $this->dbConnection->upsert('user', $user->getId()->getValue(), [
            'name' => $user->getName()->getValue(),
            'email' => $user->getEmail()->getValue(),
        ]);

        $this->dispatcher->dispatchEvent(new UserSaved($user));
    }

    public function saveAll(UserCollection $userCollection): void
    {
        $data = [];
        foreach ($userCollection->getValues() as $user) {
            $data[] = [
                'name' => $user->getName()->getValue(),
                'email' => $user->getEmail()->getValue(),
            ];
        }

        $this->dbConnection->insertBatch('user', $data);

        foreach ($userCollection->getValues() as $user) {
            $this->dispatcher->dispatchEvent(new UserSaved($user));
        }
    }
}
