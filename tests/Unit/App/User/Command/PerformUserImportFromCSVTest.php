<?php

use App\Action\ImportUsersFromCSV;
use App\Common\File\CSVReader;
use App\User\Command\PerformUserImportFromCSV;
use App\User\Domain\Import\Core\ImportedUserMapper;
use App\User\Domain\Import\CSV\CSVDataParser;
use App\User\Persistence\Mapper\UserCollectionMapper;
use App\User\Persistence\UserRepository;
use PHPUnit\Framework\TestCase;

class PerformUserImportFromCSVTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var ImportUsersFromCSV
     */
    private $action;
    /**
     * @var CSVDataParser|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $importer;
    /**
     * @var ImportedUserMapper|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $mapper;
    /**
     * @var \App\User\Persistence\UserRepository|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $repository;
    /**
     * @var \App\Common\File\CSVReader|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $CSVReader;
    /**
     * @var UserCollectionMapper|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $collectionMapper;

    protected function setUp()
    {
        $this->importer = Mockery::spy(CSVDataParser::class);
        $this->mapper = Mockery::spy(ImportedUserMapper::class);
        $this->repository = Mockery::spy(UserRepository::class);
        $this->CSVReader = Mockery::spy(CSVReader::class);
        $this->collectionMapper = Mockery::spy(UserCollectionMapper::class);
        $this->action = new PerformUserImportFromCSV(
            $this->importer,
            $this->mapper,
            $this->repository,
            $this->CSVReader,
            $this->collectionMapper
        );

        parent::setUp();
    }

    public function testSavesPerformedCorrectly()
    {
        $returnValues = [[]];
        foreach (range(1, 25) as $i) {
            $returnValues[] = ["user$i", "email$i"];
        }
        $returnValues[] = false;

        $this->CSVReader->shouldReceive('readFile')->andReturnValues($returnValues);

        $this->repository->shouldReceive('saveAll')->twice();

        $this->action->run('some-resource');
    }
}
