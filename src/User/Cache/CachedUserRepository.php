<?php
declare(strict_types=1);

namespace App\User\Cache;

use App\Common\Cache\ConnectionInterface;
use App\User\Domain\Core\User;
use App\User\Persistence\DTO\SearchCriteria;
use App\User\Persistence\DTO\UserCollection;
use App\User\Persistence\UserRepositoryInterface;

class CachedUserRepository implements UserRepositoryInterface
{
    private UserRepositoryInterface $repository;

    private ConnectionInterface $cache;

    private KeyGenerator $cacheKeyGenerator;

    private GroupTagGenerator $groupTagGenerator;

    /**
     * CachedUserRepository constructor.
     */
    public function __construct(
        UserRepositoryInterface $repository,
        ConnectionInterface $cache,
        KeyGenerator $generator,
        GroupTagGenerator $groupTagGenerator
    ) {
        $this->repository = $repository;
        $this->cache = $cache;
        $this->cacheKeyGenerator = $generator;
        $this->groupTagGenerator = $groupTagGenerator;
    }

    public function find(SearchCriteria $criteria): UserCollection
    {
        $key = $this->cacheKeyGenerator->generateKey($criteria);
        $group = $this->groupTagGenerator->generate();

        $cached = $this->cache->read($key);
        if (!is_null($cached)) {
            return unserialize($cached);
        }

        $userCollection = $this->repository->find($criteria);
        $serializedData = serialize($userCollection);

        $this->cache->write($key, $serializedData, $group);

        return $userCollection;
    }

    public function save(User $user): void
    {
        $this->repository->save($user);

        $group = $this->groupTagGenerator->generate();
        $this->cache->resetGroup($group);
    }

    public function saveAll(UserCollection $userCollection): void
    {
        $this->repository->saveAll($userCollection);

        $group = $this->groupTagGenerator->generate();
        $this->cache->resetGroup($group);
    }
}
