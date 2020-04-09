<?php

use App\Common\DB\ConnectionInterface;
use App\Common\Event\Dispatcher;
use App\User\Domain\Core\Email;
use App\User\Domain\Core\IdGeneratorInterface;
use App\User\Domain\Core\Name;
use App\User\Domain\Core\Status\AbstractStatus;
use App\User\Domain\Core\User;
use App\User\Persistence\DTO\SearchCriteria;
use App\User\Persistence\DTO\UserCollection;
use App\User\Persistence\Mapper\UserCollectionMapper;
use App\User\Persistence\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var UserRepository
     */
    private $object;
    /**
     * @var ConnectionInterface|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $connection;
    /**
     * @var SearchCriteria
     */
    private $criteria;
    /**
     * @var User
     */
    private $defaultUser;
    /**
     * @var UserCollection|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $defaultCollection;
    /**
     * @var Dispatcher|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $dispatcher;
    /**
     * @var UserCollectionMapper|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $mapper;

    protected function setUp()
    {
        $this->connection = Mockery::spy(ConnectionInterface::class);
        $this->mapper = Mockery::spy(UserCollectionMapper::class);
        $this->dispatcher = Mockery::spy(Dispatcher::class);

        $this->object = new UserRepository(
            $this->connection,
            $this->mapper,
            $this->dispatcher
        );

        $idGenerator = Mockery::spy(IdGeneratorInterface::class);
        $idGenerator->allows([
            'generate' => new \App\User\Domain\Core\UserId('id')
        ]);
        $this->defaultUser = new User(
            $idGenerator,
            Mockery::spy(Name::class),
            Mockery::spy(Email::class),
            Mockery::spy(AbstractStatus::class),
        );
        $this->defaultCollection = new UserCollection([$this->defaultUser]);

        $this->criteria = Mockery::spy(SearchCriteria::class);
        parent::setUp();
    }

    public function testSave()
    {
        $this->object->save($this->defaultUser);

        $this->connection->shouldHaveReceived('upsert');

        $this->dispatcher
            ->shouldHaveReceived('dispatchEvent')
            ->once();
    }

    public function testFind()
    {
        $this->object->find($this->criteria);

        $this->connection->shouldHaveReceived('select');
    }

    public function testSaveAll()
    {
        $this->object->saveAll($this->defaultCollection);

        $this->connection->shouldHaveReceived('insertBatch');

        $this->dispatcher
            ->shouldHaveReceived('dispatchEvent')
            ->times(
                count($this->defaultCollection->getValues())
            );
    }
}
