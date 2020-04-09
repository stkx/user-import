<?php
declare(strict_types=1);

namespace App\User\Command;

use App\Common\File\CSVReader;
use App\User\Domain\Import\Core\ImportedUserMapper;
use App\User\Domain\Import\CSV\CSVDataParser;
use App\User\Persistence\Mapper\UserCollectionMapper;
use App\User\Persistence\UserRepositoryInterface;

class PerformUserImportFromCSV
{
    private CSVDataParser $importer;

    private ImportedUserMapper $mapper;

    private CSVReader $CSVReader;

    private UserCollectionMapper $userCollectionMapper;

    private UserRepositoryInterface $repository;

    /**
     * ImportUsersFromCSV constructor.
     */
    public function __construct(
        CSVDataParser $importer,
        ImportedUserMapper $mapper,
        UserRepositoryInterface $repository,
        CSVReader $CSVReader,
        UserCollectionMapper $userCollectionMapper
    ) {
        $this->importer = $importer;
        $this->mapper = $mapper;
        $this->CSVReader = $CSVReader;
        $this->userCollectionMapper = $userCollectionMapper;
        $this->repository = $repository;
    }

    public function run($resource): void
    {
        $i = 0;
        $users = [];
        while (false !== ($data = $this->CSVReader->readFile($resource))) {
            if (!count($data)) {
                continue;
            }
            ++$i;

            $dto = $this->importer->parse($data);
            $users[] = $this->mapper->mapUserFromDTO($dto);

            if (0 === $i % 20) {
                $userCollection = $this->userCollectionMapper->mapFromArray($users);
                $this->repository->saveAll($userCollection);
                $i = 0;
                $users = [];
            }
        }

        $userCollection = $this->userCollectionMapper->mapFromArray($users);
        $this->repository->saveAll($userCollection);
    }
}
