<?php

use App\Common\Cache\ConnectionInterface;
use App\User\Cache\CachedUserRepository;
use App\User\Cache\GroupTagGenerator;
use App\User\Cache\KeyGenerator;
use App\User\Persistence\UserRepository;
use PHPUnit\Framework\TestCase;

class CachedUserRepositoryTest extends TestCase
{
    use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var UserRepository|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $userRepository;
    /**
     * @var ConnectionInterface|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $cache;
    /**
     * @var KeyGenerator|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $keyGenerator;
    /**
     * @var GroupTagGenerator|\Mockery\LegacyMockInterface|\Mockery\MockInterface
     */
    private $groupTagGenerator;

    private CachedUserRepository $repo;

    private \App\User\Persistence\DTO\SearchCriteria $criteria;

    protected function setUp()
    {
        $this->userRepository = Mockery::spy(UserRepository::class);
        $this->cache = Mockery::spy(ConnectionInterface::class);
        $this->keyGenerator = Mockery::spy(KeyGenerator::class);
        $this->groupTagGenerator = Mockery::spy(GroupTagGenerator::class);
        $this->repo = new CachedUserRepository(
            $this->userRepository,
            $this->cache,
            $this->keyGenerator,
            $this->groupTagGenerator,
        );

        $this->criteria = new \App\User\Persistence\DTO\SearchCriteria('1', '2');
    }

    public function testCacheIsResetOnSave()
    {
        $this->repo->save(Mockery::spy(\App\User\Domain\Core\User::class));

        $this->cache->shouldHaveReceived('resetGroup');
    }

    public function testCacheIsResetOnMassSave()
    {
        $this->repo->saveAll(Mockery::spy(\App\User\Persistence\DTO\UserCollection::class));

        $this->cache->shouldHaveReceived('resetGroup');
    }

    public function testCachedIsReturnOnFindIfExist()
    {
        $collectionMock = new \App\User\Persistence\DTO\UserCollection([]);

        $this->cache->shouldReceive('read')->andReturn(
            serialize($collectionMock)
        );

        $result = $this->repo->find($this->criteria);

        $this->assertEquals($collectionMock, $result);
    }

    public function testWriteIsPerformedWhenNoCache()
    {
        $collectionMock = new \App\User\Persistence\DTO\UserCollection([]);

        $this->cache->shouldReceive('read')->andReturn(null);
        $this->userRepository->shouldReceive('find')->andReturn($collectionMock);
        $this->cache->shouldReceive('write');

        $result = $this->repo->find($this->criteria);

        $this->assertEquals($collectionMock, $result);
    }
}
